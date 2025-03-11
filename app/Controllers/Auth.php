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

	public function send_resetpassword()
	{
		// Pastikan ini adalah request AJAX
		if (!$this->request->isAJAX()) {
			return $this->response->setStatusCode(400)->setJSON([
				'code'    => 400,
				'message' => 'Request not valid'
			]);
		}

		$email = $this->request->getVar('email');

		if (empty($email)) {
			return $this->response->setJSON([
				'code'    => 400,
				'message' => 'Email not found.'
			]);
		}

		$email = urldecode($email);
		$subject = "Satoshi Signal - Reset Password";

		try {
			// Call Endpoint Member
			$url = URLAPI . "/auth/resend_token";
			$apiResponse = satoshiAdmin($url, json_encode(['email' => $email]));

			// Pastikan $apiResponse adalah objek
			if (!is_object($apiResponse)) {
				return $this->response->setJSON([
					'code'    => 500,
					'service' => 'auth',
					'error'   => 'Invalid response',
					'message' => 'Invalid response from API.'
				]);
			}

			$result = $apiResponse->result;

			// Cek apakah $result adalah objek dan memiliki properti yang diharapkan
			if (is_object($result)) {
				if (isset($result->message)) {
					// Jika ada pesan, ambil token dari dalam pesan
					$token = $result->message->otp ?? null; // Menggunakan null coalescing operator

					if ($token === null) {
						return $this->response->setJSON([
							'code'    => 500,
							'service' => 'auth',
							'error'   => 'Missing OTP',
							'message' => 'OTP not found in response.'
						]);
					}
				} else {
					return $this->response->setJSON([
						'code'    => 500,
						'service' => 'auth',
						'error'   => 'Unexpected response format',
						'message' => 'No message in response.'
					]);
				}
			} else {
				// Jika $result adalah string, tangani dengan benar
				if (is_string($result)) {
					return $this->response->setJSON([
						'code'    => 500,
						'service' => 'auth',
						'error'   => 'Unexpected response format',
						'message' => $result // Mengembalikan string sebagai pesan
					]);
				}

				return $this->response->setJSON([
					'code'    => 500,
					'service' => 'auth',
					'error'   => 'Invalid response format',
					'message' => 'Failed to get OTP from API.'
				]);
			}

			// Kirim email dengan token
			try {
				$emailSent = sendmail_satoshi($email, $subject, emailtemplate_forgot_password($token, $email));

				// Jika sendmail_satoshi tidak mengembalikan nilai, anggap berhasil
				// (karena fungsi aslinya tidak mengembalikan nilai)

				// Kembalikan respons sukses
				return $this->response->setJSON([
					'code'    => 200,
					'message' => 'Email has been sent to your email'
				]);
			} catch (Exception $e) {
				log_message('error', 'Error sending email: ' . $e->getMessage());
				return $this->response->setJSON([
					'code'    => 500,
					'service' => 'email',
					'error'   => 'Email error',
					'message' => 'Failed to send email: ' . $e->getMessage()
				]);
			}
		} catch (Exception $e) {
			log_message('error', 'Error in send_resetpassword: ' . $e->getMessage());
			return $this->response->setJSON([
				'code'    => 500,
				'service' => 'system',
				'error'   => 'System error',
				'message' => 'System error: ' . $e->getMessage()
			]);
		}
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
			'emailuser' => $email,
			'footer'    => false,
			'darkNav'   => true
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

	public function resend_token()
	{
		$email = $this->request->getPost('email');
		$email = urldecode($email);

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return $this->response->setJSON([
				'code'    => 400,
				'service' => 'auth',
				'error'   => 'Invalid email',
				'message' => 'Email tidak valid.'
			]);
		}

		$url = URLAPI . "/auth/resend_token";
		$apiResponse = satoshiAdmin($url, json_encode(['email' => $email]));

		// Maka penyesuaian akses harus dilakukan sesuai struktur tersebut.
		$result = $apiResponse->result;

		// Cek apakah OTP berada di level langsung dari $result atau di dalam $result->message
		if (isset($result->otp)) {
			$otp = $result->otp;
		} elseif (isset($result->message->otp)) {
			$otp = $result->message->otp;
		} else {
			return $this->response->setJSON([
				'code'    => 500,
				'service' => 'auth',
				'error'   => 'OTP not found in API response',
				'message' => 'Failed to get OTP from API.'
			]);
		}

		$subject = "Activation Account - " . SATOSHITITLE;
		sendmail_satoshi($email, $subject, emailtemplate_resend_token($otp, $email));

		// Proses pengiriman email jika diperlukan, dsb.
		return $this->response->setJSON([
			'code'    => 200,
			'service' => 'auth',
			'error'   => null,
			'message' => [
				'text' => 'Your token has been resent via email',
				'otp'  => $otp
			]
		]);
	}

	public function postLogin()
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
			session()->setFlashdata('failed', $this->validator->listErrors());
			return redirect()->to(BASE_URL . 'member/auth/login')->withInput();
		}

		$email = htmlspecialchars($this->request->getVar('email'));
		$password = htmlspecialchars($this->request->getVar('password'));

		$password = trim($password);
		$password = sha1($password);

		// Buat data untuk dikirim ke API
		$mdata = [
			'email'    => $email,
			'password' => $password,
		];

		$tempUser = (object)[
			'email'  => htmlspecialchars($this->request->getVar('email')),
			'passwd' => sha1($this->request->getVar('password'))
		];
		session()->set('logged_user', $tempUser);

		// Proccess Endpoin API
		$url = URLAPI . "/auth/signin";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 200) {
			// Gabungkan data user dengan token
			$loggedUser = $result->message;
			// Simpan data user lengkap tersebut ke session
			session()->set('logged_user', $loggedUser);

			// Redirect berdasarkan role
			if ($loggedUser->role === 'admin') {
				return redirect()->to(BASE_URL . 'godmode/dashboard');
			} elseif ($loggedUser->role === 'member') {
				// Pengalihan untuk member saat ini dinonaktifkan
				return redirect()->to(BASE_URL . 'member/dashboard');
			}
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'member/auth/login');
		}
	}
}
