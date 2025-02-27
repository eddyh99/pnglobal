<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Auth extends BaseController
{

	protected $validation;
	protected $session;

	public function __construct()
	{
		$this->validation = \Config\Services::validation();
		$this->session = \Config\Services::session();
	}

	public function register()
	{
		$mdata = [
			'title'     => 'Register - ' . SATOSHITITLE,
			'content'   => 'member/subscription/register',
			'extra'     => 'member/subscription/js/_js_register',
		];

		return view('member/layout/wrapper', $mdata);
	}

	public function login()
	{
		$mdata = [
			'title'     => 'Login - ' . SATOSHITITLE,
			'content'   => 'member/subscription/login',
			'extra'     => 'member/subscription/js/_js_login',
		];

		return view('member/layout/login_wrapper', $mdata);
	}

	public function forgot_password()
	{
		$mdata = [
			'title'     => 'Reset Password - ' . SATOSHITITLE,
			'content'   => 'member/subscription/forgot_password',
			'extra'     => 'member/subscription/js/_js_forgot_password',
		];

		return view('member/layout/login_wrapper', $mdata);
	}

	public function signup()
	{
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
			session()->setFlashdata('failed', $this->validation->listErrors());
			return redirect()->to(BASE_URL . 'member/auth/register')->withInput();
		}

		// Initial Data
		$mdata = [
			'email'         => htmlspecialchars($this->request->getVar('email')),
			'password'      => htmlspecialchars($this->request->getVar('password')),
			'referral'      => htmlspecialchars($this->request->getVar('referral')),
			'ipaddress'     => $this->request->getIPAddress(),
		];

		// Trim Data
		$mdata['password'] = trim($mdata['password']);

		// Password Encrypt
		$mdata['password'] = sha1($mdata['password']);

		// Proccess Endpoin API
		$url = URLAPI . "/auth/register";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;
		if ($result->code == 201) {
			$this->send_activation(urlencode($mdata["email"]), $result->message->token);
			return redirect()->to(BASE_URL . 'member/auth/pricing?email=' . $mdata["email"]);
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'member/auth/register');
		}
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
			session()->setFlashdata('failed', $this->validator->listErrors());
			return redirect()->to(BASE_URL . 'member/auth/login')->withInput();
		}

		// Initial Data
		$mdata = [
			'email'     => htmlspecialchars($this->request->getVar('email')),
			'password'  => htmlspecialchars($this->request->getVar('password')),
		];

		// Password Encrypt
		$mdata['password'] = sha1($mdata['password']);

		// Proccess Endpoin API
		$url = URLAPI . "/auth/login";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;
		if ($result->code == 200) {
			return redirect()->to(BASE_URL . 'member/auth/pricing?email=' . $mdata["email"]);
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'member/auth/login');
		}
	}


	public function pricing()
	{
		// Call Endpoin total_exclusive
		$url = URLAPI . "/auth/readprice";
		$result = satoshiAdmin($url)->result->message;

		$email = @$_GET['mail'];

		// Call Endpoin Member
		$url = URLAPI . "/auth/getmember_byemail?email=" . $email;
		$resultMember = satoshiAdmin($url)->result->message;

		$ref = @$resultMember->id_referral;
		$mdata = [
			'title'     => 'Subscription - ' . SATOSHITITLE,
			'content'   => 'widget/subscription/subscription',
			'extra'     => 'widget/subscription/js/_js_subcription',
			'subsprice' => $result,
			'ref'       => $ref,
			'email'     => $email
		];

		return view('widget/layout/wrapper', $mdata);
	}

	public function index()
	{
		$mdata = [
			'title'     => 'Active Account - ' . SATOSHITITLE,
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];
		return view('widget/layout/wrapper', $mdata);
	}


	public function active_account($token)
	{
		// Call Endpoin Active Account
		$url = URLAPI . "/auth/activate?token=" . $token;
		$result = satoshiAdmin($url)->result;

		$mdata = [
			'title'     => 'Active Account - ' . SATOSHITITLE,
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];

		return view('widget/layout/wrapper', $mdata);
	}

	public function send_activation($email, $token)
	{
		$email = urldecode($email);
		$subject =  SATOSHITITLE . " - Activation Account";


		$token = $token;

		$message = "
		<!DOCTYPE html>
		<html lang='en'>

		<head>
			<meta name='color-scheme' content='light'>
			<meta name='supported-color-schemes' content='light'>
			<title>Activation Account Satoshi Signal</title>
		</head>

		<body>
			<div style='
			max-width: 420px;
			margin: 0 auto;
			position: relative;
			padding: 1rem;
			'>
				<div style='
				text-align: center;
				padding: 3rem;
				'>
					<h3 style='
					font-weight: 600;
					font-size: 30px;
					line-height: 45px;
					color: #000000;
					margin-bottom: 1rem;
					text-align: center;
					'>
						Dear, User
					</h3>
				</div>

				<div style='
				text-align: center;
				padding-bottom: 1rem;
				'>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Thank you for register Satoshi Signal. To proceed with your request, please click link Active Account Below
					</p>
					<h2><a target='_blank' href='" . BASE_URL . "auth/active_account/" . $token . "'></a>" . BASE_URL . "auth/active_account/" . $token . "</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						Satoshi Signal Team

					</p>
				</div>
				<hr>
				<hr>
				<p style='
				text-align: center;
				font-weight: 400;
				font-size: 12px;
				color: #999999;
				'>
					Copyright © " . date('Y') . "
				</p>
			</div>
		</body>
		</html>";

		sendmail_satoshi($email, $subject, $message);
	}

	public function send_resetpassword($email)
	{
		$email = urldecode($email);
		$subject = SATOSHITITLE . " - Reset Password";


		// Call Endpoin Member
		$url = URLAPI . "/auth/getmember_byemail?email=" . $email;
		$resultMember = satoshiAdmin($url)->result->message;


		$message = "
		<!DOCTYPE html>
		<html lang='en'>

		<head>
			<meta name='color-scheme' content='light'>
			<meta name='supported-color-schemes' content='light'>
			<title>Activation Account Satoshi Signal</title>
		</head>

		<body>
			<div style='
			max-width: 420px;
			margin: 0 auto;
			position: relative;
			padding: 1rem;
			'>
				<div style='
				text-align: center;
				padding: 3rem;
				'>
					<h3 style='
					font-weight: 600;
					font-size: 20px;
					line-height: 45px;
					color: #000000;
					margin-bottom: 1rem;
					text-align: center;
					'>
						Dear, <br> " . $email . "
					</h3>
				</div>

				<div style='
				text-align: center;
				padding-bottom: 1rem;
				'>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Thank you for using Satoshi Signal App. To proceed with your request, please copy token reset password below 
					</p>
					<h2 id='copyToken'>
						" . $resultMember->token . "
					</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						Satoshi Signal Team

					</p>
				</div>
				<hr>
				<hr>
				<p style='
				text-align: center;
				font-weight: 400;
				font-size: 12px;
				color: #999999;
				'>
					Copyright © " . date('Y') . "
				</p>
			</div>
		</body>
		</html>";

		sendmail_satoshi($email, $subject, $message);
	}

	public function forgot_pass_otp($emailuser)
	{
		$emailuser = urldecode($emailuser);

		$mdata = [
			'title'     => 'Forgot Password - Satoshi Signal',
			'content'   => 'member/subscription/forgot_pass_otp',
			'extra'     => 'member/subscription/js/_js_forgot_pass_otp',
			'emailuser' => $emailuser
		];

		return view('member/layout/login_wrapper', $mdata);
	}

	public function reset_password_confirmation()
	{
		$email = $this->request->getPost('email');
		$otp   = $this->request->getPost('otp');

		if (empty($email) || empty($otp)) {
			session()->setFlashdata('failed', 'Email atau OTP tidak ditemukan.');
			return redirect()->to(BASE_URL . 'member/auth/forgot_pass_otp/' . base64_encode($email));
		}

		$mdata = [
			'title' => 'Reset Password Confirmation',
			'content' => 'member/subscription/reset_password_confirmation',
			'extra' => 'member/subscription/js/_js_reset_password_confirmation',
			'email' => $email,
			'otp'   => $otp
		];

		return view('member/layout/login_wrapper', $mdata);
	}

	public function update_password()
	{
		$email = $this->request->getPost('email');
		$otp   = $this->request->getPost('otp');
		$password = $this->request->getPost('password');
		$confirm_password = $this->request->getPost('confirm_password');

		if (empty($email) || empty($otp) || empty($password) || empty($confirm_password)) {
			session()->setFlashdata('failed', 'Email atau OTP tidak ditemukan.');
			return redirect()->to(BASE_URL . 'member/auth/reset_password_confirmation/' . base64_encode($email));
		}

		if ($password !== $confirm_password) {
			session()->setFlashdata('failed', 'Password tidak sama.');
			return redirect()->to(BASE_URL . 'member/auth/reset_password_confirmation/' . base64_encode($email));
		}

		$mdata = [
			'email' => $email,
			'otp'   => $otp,
			'password' => $password
		];

		$url = URLAPI . "/auth/reset_password";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 200) {
			session()->setFlashdata('success', 'Password berhasil diubah.');
			return redirect()->to(BASE_URL . 'member/auth/login');
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'member/auth/login');
		}
	}

	public function logout()
	{
		$this->session->remove('logged_user');
		return redirect()->to(BASE_URL . 'member/auth/login');
	}
}
