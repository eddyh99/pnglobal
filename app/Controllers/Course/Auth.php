<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Auth extends BaseController
{

    public function login($role = null) {

        if (!in_array($role, ['mentor', 'member'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $session = session();
        if($session->has('logged_usercourse')){
            return redirect()->to(BASE_URL . "course/" . $role);
            exit();
        }

        $mdata = [
            'title'     => 'Login Course - ' . NAMETITLE,
            'content'   => 'course/login/index',
            'active_dashboard'    => 'active active-menu',
            'extra'     => 'course/login/js/_js_index',
            'role'      => $role
        ];

        return view('hedgefund/layout/wrapper', $mdata);
    }

    public function mentorlogin_proccess()
    {
        $response = $this->handleLogin();
    
        if (!$response->success || $response->message->status != 200 || $response->message->result->code != 200) {
            $errorMsg = $response->success ? $response->message->result->message : $response->message;
            session()->setFlashdata('failed', $errorMsg);
            return redirect()->to(BASE_URL . 'course/login/mentor')->withInput();
        }
    
        $loggedUser = $response->message->result->message;
    
        if (!$loggedUser || $loggedUser->role !== 'mentor') {
            session()->setFlashdata('failed', 'Access denied. Please login as a mentor.');
            return redirect()->to(BASE_URL . 'course/login/mentor');
        }
    
        session()->set('logged_usercourse', $loggedUser);
        session()->setFlashdata('success', 'Welcome to course');
        return redirect()->to(BASE_URL . 'course/mentor/message');
    }

    public function memberlogin_proccess()
    {
        $response = $this->handleLogin();
    
        if (!$response->success || $response->message->status != 200 || $response->message->result->code != 200) {
            $errorMsg = $response->success ? $response->message->result->message : $response->message;
            session()->setFlashdata('failed', $errorMsg);
            return redirect()->to(BASE_URL . 'course/login/member')->withInput();
        }
    
        $loggedUser = $response->message->result->message;
    
        if (!$loggedUser || $loggedUser->role !== 'member') {
            session()->setFlashdata('failed', 'Access denied. Please login as a member.');
            return redirect()->to(BASE_URL . 'course/login/member');
        }
    
        session()->set('logged_usercourse', $loggedUser);
        session()->setFlashdata('success', 'Welcome to course');
        return redirect()->to(BASE_URL . 'course/member');
    }
    
    private function handleLogin() {
         // Validation Field
         $rules = $this->validate([
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email'
            ],
            'password'     => [
                'label'     => 'Password',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            return (object) [
                'success' => false,
                'message' => $this->validation->listErrors()
            ];
        }

        // Initial Data
        $mdata = [
            'email'         => htmlspecialchars($this->request->getVar('email')),
            'password'      => htmlspecialchars($this->request->getVar('password')),
        ];

        // Trim Data
        $mdata['password'] = trim($mdata['password']);

        // Password Encrypt
        $mdata['password'] = sha1($mdata['password']);

        // Proccess Endpoin API
        $url = URL_COURSE . "/auth/signin";
        $response = courseAdmin($url, json_encode($mdata));

        return (object) [
            'success' => true,
            'message' => $response
        ];
    }

    public function verify_token($email = null)
	{
        if(!$email) {
            session()->setFlashdata('failed', 'The request has failed. Please try again later.');
            return redirect()->to(BASE_URL . 'course/login/member')->withInput();
        }
		$emailuser = urldecode($email);
		$mdata = [
			'title'     => 'Forgot Password - Satoshi Signal',
			'content'   => 'course/login/verify_token',
			'emailuser' => $emailuser
		];

		return view('member/layout/login_wrapper', $mdata);
	}

    public function send_token() {
        $isValid = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
            ],
        ]);

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'course/auth/forgot_password')->withInput();
        }

        $email = $this->request->getVar('email');
        $url = URL_COURSE . "/auth/resendtoken";
        $response = courseAdmin($url, json_encode([
            'email' => $email
        ]));
        $result = $response->result;

        if($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/auth/forgot_password')->withInput();
        }
        
        // $email_template = emailtemplate_activation_course($otp, $email);
        // sendmail_satoshi($email, "Activation Account Satoshi Signal", $email_template);
        session()->setFlashdata('success', $result->message->text ?? '');
        return redirect()->to(BASE_URL . 'course/auth/verify_token/' . base64_encode($email));
    }

    public function reset_password_confirmation()
	{
		$email = $this->request->getPost('email') ?? old('email');
		$otp   = $this->request->getPost('otp') ?? old('otp');

		if (empty($email) || empty($otp)) {
			session()->setFlashdata('failed', 'Email or token could not be found.');
			return redirect()->to(BASE_URL . 'course/auth/verify_token/' . base64_encode($email));
		}

        if(!$this->checkotp($email, $otp)) {
            session()->setFlashdata('failed', 'Invalid token');
			return redirect()->to(BASE_URL . 'course/auth/verify_token/' . base64_encode($email));
        };

		$mdata = [
			'title' => 'Reset Password Confirmation',
			'content' => 'course/login/reset_password_confirmation',
			// 'extra' => 'course/reset/js/_js_reset_password_confirmation',
			'email' => $email,
			'otp'   => $otp
		];

		return view('member/layout/login_wrapper', $mdata);
	}

    private function checkotp($email, $otp)
    {
        $url = URL_COURSE . "/auth/otp_check";
        $response = courseAdmin($url, json_encode([
            'email' => $email,
            'otp'   => $otp
        ]));
    
        return isset($response->result->code, $response->result->message)
        && $response->result->code == 200
        && $response->result->message == true;
    }
    

    public function update_password()
	{

        $isValid = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
            ],
            'otp' => [
                'label' => 'Kode OTP',
                'rules' => 'required|numeric|exact_length[4]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]',
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
            ],
        ]);

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'course/auth/reset_password_confirmation')->withInput();
        }

        $email = $this->request->getPost('email');
		$otp   = $this->request->getPost('otp');
		$password = $this->request->getPost('password');

		$mdata = [
			'email' => $email,
			'otp'   => $otp,
			'password' => sha1($password)
		];

		$url = URL_COURSE . "/auth/resetpassword";
		$response = courseAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 201) {
			session()->setFlashdata('success', 'Password berhasil diubah.');
			return redirect()->to(BASE_URL . 'course/login/member');
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'course/auth/reset_password_confirmation')->withInput();
		}
	}


    public function logout()
    {
        $role = $this->session->get('logged_usercourse')->role ?? null;
        $this->session->remove('logged_usercourse');
        return redirect()->to(BASE_URL . 'course/login/' . ($role ?? 'member'));
    }

    public function forgot_password()
	{
		$mdata = [
			'title'     => 'Reset Password - ' . NAMETITLE,
			'content'   => 'course/login/forgot_password',
		];

		return view('member/layout/login_wrapper', $mdata);
	}
}