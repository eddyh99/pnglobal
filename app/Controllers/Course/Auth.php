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
            return redirect()->to(BASE_URL . "course");
            exit();
        }

        $mdata = [
            'title'     => 'Login Course - ' . NAMETITLE,
            'content'   => 'course/login/' . $role,
            'active_dashboard'    => 'active active-menu',
            'extra'     => 'course/login/js/_js_index'
        ];

        return view('elite/layout/wrapper', $mdata);
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
        return redirect()->to(BASE_URL . 'course');
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
        return redirect()->to(BASE_URL . 'course');
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
        $url = URLAPI . "/auth/signin_course";
        $response = satoshiAdmin($url, json_encode($mdata));

        return (object) [
            'success' => true,
            'message' => $response
        ];
    }


    public function logout()
    {
        $this->session->remove('logged_usercourse');
        return redirect()->to(BASE_URL . 'course/login/member');
    }
}