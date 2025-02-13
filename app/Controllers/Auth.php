<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
	public function index()
	{
		$mdata = [
			'title'     => 'Active Account - Satoshi Signal',
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
			'title'     => 'Active Account - Satoshi Signal',
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];

		return view('widget/layout/wrapper', $mdata);
	}

	public function send_activation($email)
	{
		$email = urldecode($email);
		$subject = "Satoshi Signal - Activation Account";


		$token = $_GET['token'];

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
		$subject = "Satoshi Signal - Reset Password";


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

	public function activate_member($email = null)
	{
		if ($email === null) {
			return redirect()->to('auth/index');
		}
		$email = urldecode($email);
		// Tampilkan form aktivasi
		$mdata = [
			'title'     => 'Active Account - Satoshi Signal',
			'content'   => 'homepage/service/satoshi-otp',
			'extra'     => 'homepage/service/js/_js_satoshi_otp',
			'emailuser' => $email
		];

		return view('homepage/layout/wrapper', $mdata);
	}

	public function process_otp()
	{
		// Pastikan ini adalah AJAX request
		if (!$this->request->isAJAX()) {
			return $this->response->setJSON([
				'code' => '400',
				'message' => 'Invalid request method'
			]);
		}

		try {
			// Ambil data dari POST
			$email = $this->request->getPost('email');
			$otp = $this->request->getPost('otp');

			if (empty($email) || empty($otp)) {
				return $this->response->setJSON([
					'code' => '400',
					'message' => 'Email and OTP are required'
				]);
			}

			// Siapkan data untuk dikirim ke API
			$mdata = [
				'email' => $email,
				'otp'   => $otp
			];

			// Call Endpoint Activate Member
			$url = URLAPI . "/auth/activate_member";
			$response = satoshiAdmin($url, json_encode($mdata));

			return $this->response->setJSON([
				'code' => $response->result->code ?? '400',
				'message' => $response->result->message ?? 'Failed to process request'
			]);
		} catch (\Exception $e) {
			log_message('error', 'OTP Processing Error: ' . $e->getMessage());
			return $this->response->setJSON([
				'code' => '500',
				'message' => 'Server Error: ' . $e->getMessage()
			]);
		}
	}

	// Tambahkan method untuk halaman sukses
	public function active_account_success()
	{
		$mdata = [
			'title'     => 'Active Account Success - Satoshi Signal',
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];

		return view('widget/layout/wrapper', $mdata);
	}
}
