<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
    }

    public function signin()
    {
        $mdata = [
            'title'     => 'Sign in - ' . NAMETITLE,
            'content'   => 'godmode/auth/index',
            'extra'     => 'godmode/auth/js/_js_index',
        ];

        return view('godmode/layout/login_wrapper', $mdata);
    }

    public function auth_proccess()
    {
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
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/auth/signin')->withInput();
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
        $url = URLAPI . "/auth/signin";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
		if ($response->status == 200 || $result->code == 200) {
			$loggedUser = $result->message;
 			session()->set('logged_user', $loggedUser);
			session()->setFlashdata('success', 'Welcome to admin panel');
			if ($loggedUser->role=='superadmin') {
          		return redirect()->to(BASE_URL . 'godmode/signal');
 			}elseif ($loggedUser->role=='admin') {
				$access = json_decode($loggedUser->access, true);
                if (!empty($access['hedgefund']) && in_array('dashboard', $access['hedgefund'])) {
                    return redirect()->to(BASE_URL . 'godmode/dashboard/hedgefund');
				}elseif (!empty($access['hedgefund']) && in_array('payment', $access['hedgefund'])) {
                    return redirect()->to(BASE_URL . 'godmode/payment/hedgefund');
                } elseif (!empty($access['hedgefund']) && in_array('referral', $access['hedgefund'])) {
                    return redirect()->to(BASE_URL . 'godmode/dashboard/hedgefund');
                } elseif (!empty($access['console']) && in_array('console only', $access['console'])) {
                    return redirect()->to(BASE_URL . 'godmode/signal');
                } elseif (!empty($access['console']) && in_array('history', $access['console'])) {
                    return redirect()->to(BASE_URL . 'godmode/history-hedgefund');
                } elseif (!empty($access['console']) && in_array('otc', $access['console'])) {
                    return redirect()->to(BASE_URL . 'godmode/otc');
                } elseif (!empty($access['console']) && in_array('mediation', $access['console'])) {
                    return redirect()->to(BASE_URL . 'godmode/mediation');
                }
          		return redirect()->to(BASE_URL . 'godmode/signal');
 			}
 			session()->setFlashdata('failed', 'Access Denied');
 		} else {
 			session()->setFlashdata('failed', $result->message);
		}

		return redirect()->to(BASE_URL . 'godmode/auth/signin');
    }
    
    

    public function logout()
    {
        $this->session->remove('logged_user');
        return redirect()->to(BASE_URL . 'godmode/auth/signin');
    }

    public function forgot_password()
	{
		$mdata = [
			'title'     => 'Reset Password - ' . NAMETITLE,
			'content'   => 'member/subscription/forgot_password',
            'mode'      => 'godmode'
		];

		return view('member/layout/login_wrapper', $mdata);
	}

    public function send_resetpassword()
	{

		$rules = $this->validate([
			'email'     => [
				'label'     => 'Email',
				'rules'     => 'required|valid_email'
			],
		]);

		// Checking Validation
		if (!$rules) {
			session()->setFlashdata('failed', $this->validator->listErrors());
			return redirect()->to(BASE_URL . 'godmode/auth/forgot_password')->withInput();
		}

		$email = $this->request->getVar('email');
		$subject = 	NAMETITLE . " - Reset Password";


		// Call Endpoin Member
		$url = URLAPI . "/auth/resend_token";
		$response = satoshiAdmin($url, json_encode(['email' => $email, 'isgodmode' => true]))->result;
        $result = $response->message;
        if ($response->code != 200) {
            session()->setFlashdata('failed', $result);
            return redirect()->to(BASE_URL . 'godmode/auth/forgot_password')->withInput();
        }

		$message = "
		<!DOCTYPE html>
		<html lang='en'>

		<head>
			<meta name='color-scheme' content='light'>
			<meta name='supported-color-schemes' content='light'>
			<title>Reset Password</title>
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
						To proceed with your request, please copy token reset password below 
					</p>
					<h2 id='copyToken'>
						" . $result->otp . "
					</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						PNGLOBAL Team

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

		sendmail_satoshi($email, $subject, $message, 'Reset Password', USERNAME_MAIL);
		session()->setFlashdata('success', $result->text);
		return redirect()->to(BASE_URL . 'godmode/auth/forgot_pass_otp/'. base64_encode($email));
	}

    public function forgot_pass_otp($emailuser)
	{

		$mdata = [
			'title'     => 'Forgot Password - Satoshi Signal',
			'content'   => 'member/subscription/forgot_pass_otp',
			'extra'     => 'member/subscription/js/_js_forgot_pass_otp',
			'emailuser' => $emailuser,
             'mode'      => 'godmode'
		];

		return view('member/layout/login_wrapper', $mdata);
	}

    public function reset_password_confirmation()
	{
		$email = $this->request->getPost('email') ?? old('email');
		$otp   = $this->request->getPost('otp') ?? old('otp');
		// dd($email);

		if (empty($email) || empty($otp)) {
			session()->setFlashdata('failed', 'Email atau OTP tidak ditemukan.');
			return redirect()->to(BASE_URL . 'godmode/auth/forgot_pass_otp/' . base64_encode($email));
		}

		if(!$this->checkotp($email, $otp)) {
            session()->setFlashdata('failed', 'Invalid token');
			return redirect()->to(BASE_URL . 'godmode/auth/forgot_pass_otp/' . base64_encode($email));
        };

		$mdata = [
			'title' => 'Reset Password Confirmation',
			'content' => 'member/subscription/reset_password_confirmation',
			'email' => $email,
			'otp'   => $otp,
            'mode'  => 'godmode'
		];

		return view('member/layout/login_wrapper', $mdata);
	}

    private function checkotp($email, $otp)
    {
        $url = URLAPI . "/auth/otp_check";
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
            return redirect()->to(BASE_URL . 'godmode/auth/reset_password_confirmation/')->withInput();
        }


        $email = $this->request->getPost('email');
		$otp   = $this->request->getPost('otp');
		$password = $this->request->getPost('password');

		$mdata = [
			'email' => $email,
			'otp'   => $otp,
			'password' => sha1($password)
		];

        // dd($mdata);

		$url = URLAPI . "/auth/reset_password";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 200) {
			session()->setFlashdata('success', 'Password berhasil diubah.');
            $this->update_password_course($mdata);
            $this->update_password_hedgefund($mdata);
			// $this->update_password_satoshi($mdata);
			return redirect()->to(BASE_URL . 'godmode/auth/signin');
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'godmode/auth/signin');
		}
	}

    private function update_password_course($mdata) {
        $mdata += ['isgodmode' => true];
        $url = URL_COURSE . "/auth/resetpassword";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

        if ($result->code != 201) {
            session()->setFlashdata('failed', 'Failed to update course account password.');
        }
    }

    private function update_password_hedgefund($mdata) {
        $mdata += ['isgodmode' => true];
		$url = URL_HEDGEFUND . "/auth/reset_password";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

        if ($result->code != 200) {
            session()->setFlashdata('failed', 'Failed to update hedge fund account password.');
        }
    }

	private function update_password_satoshi($mdata) {
        $mdata += ['isgodmode' => true];
		$url = URLAPI2 . "/auth/updatepassword";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

        if ($result->code != 200) {
            session()->setFlashdata('failed', 'Failed to update satoshi account password.');
        }
    }

	public function coinpayment_notify()
	{
		$data = $_POST;
		// NOTE !!! 
		// Issue with $url can read from config (URL_HEDGEFUND) must be set manually
		// $url = 'http://localhost:8082/apiv1/onetoone/payment';
		$url = URL_HEDGEFUND . '/apiv1/onetoone/payment';
		
		log_message('info', "================= IPN MASUK =================");
		log_message('info', "URL API Target: " . $url);
		log_message('info', "Waktu Diterima: " . date('Y-m-d H:i:s'));
		log_message('info', "Data CoinPayments:\n" . json_encode($data, JSON_PRETTY_PRINT));
		log_message('info', "=============================================");

		// Validasi status payment
		if (isset($data["status"]) && $data["status"] === "100") {

			$invoiceNumber = $data['invoice'] ?? null;

			// Tentukan status pembayaran
			$statusPayment = (!empty($data['status_text']) && strtolower($data['status_text']) === 'complete')
				? 'paid'
				: 'unpaid';

			// Payload untuk update status
			$postData = [
				'invoice_number' => $invoiceNumber,
				'status_payment' => $statusPayment
			];

			log_message('info', "Mengirim update status payment ke API: {$url}");

			// CURL request ke internal API
			$ch = curl_init($url);
			curl_setopt_array($ch, [
				CURLOPT_CUSTOMREQUEST  => "PUT",
				CURLOPT_POSTFIELDS     => json_encode($postData),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER     => [
					'Content-Type: application/json',
					'Content-Length: ' . strlen(json_encode($postData))
				]
			]);

			$response  = curl_exec($ch);
			$httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$curlError = curl_error($ch);
			curl_close($ch);

			// Logging hasil CURL
			if ($curlError) {
				log_message('error', "CURL ERROR: " . $curlError);
			}

			log_message('info', "Response dari API: " . $response);
			log_message('info', "Payload Dikirim:\n" . json_encode($postData, JSON_PRETTY_PRINT));
			log_message('info', "HTTP Code: " . $httpCode);
			$sendNotifyEmail = $this->sendpaymentstatus($data['email'], $invoiceNumber);
			// Logging hasil pengiriman email
			if ($sendNotifyEmail) {
				log_message('info', "Email notifikasi berhasil dikirim ke: " . $data['email']);
			} else {
				log_message('error', "Gagal mengirim email notifikasi ke: " . $data['email']);
			}
		} else {
			log_message('info', "Status bukan 100 atau tidak valid, IPN diabaikan.");
		}

		// Response ke CoinPayments wajib
		echo 'IPN OK';
	}

	function sendEmail($to, $subject, $title, $htmlBody)
	{
		$mail = new \PHPMailer\PHPMailer\PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->Host       = 'sandbox.smtp.mailtrap.io';
			$mail->SMTPAuth   = true;
			$mail->Username   = 'df6cfe30efaae2';
			$mail->Password   = 'bcc05333a927ee';
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;

			$mail->setFrom('no-reply@example.com', $title);
			$mail->addAddress($to);

			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body    = $htmlBody;

			$mail->send();

			log_message('info', 'Email sent to: ' . $to);
			return true;
		} catch (\Exception $e) {
			log_message('error', 'Email sending failed: ' . $mail->ErrorInfo);
			return false;
		}
	}

	public function sendpaymentstatus($email, $invoiceID)
	{
		$title         = 'Payment Status Success';
		$subject       = 'Your Payment Status';
		$emailTemplate = emailtemplate_paymentstatus_onetoone($invoiceID);

		return $this->sendEmail($email, $subject, $title, $emailTemplate);
	}
}
