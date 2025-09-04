<?php

namespace App\Controllers\Hedgefund;

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
			'title'     => 'Register Elite Management - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/register',
			'extra'     => 'hedgefund/subscription/js/_js_register',
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	public function signup_process()
	{
		// Validation Field
		$rules = $this->validate([
			'email'   => [
				'label'     => 'Email',
				'rules'     => 'valid_email'
			],
			'pass'     => [
				'label'     => 'Password',
				'rules'     => 'required|min_length[8]'
			],
			'cpass'     => [
				'label'     => 'Confirm Password',
				'rules'     => 'required|matches[pass]|min_length[8]'
			],
			'timezone'     => [
				'label'     => 'Timezone',
				'rules'     => 'required'
			],
			'referral'     => [
				'label'     => 'Referral',
				'rules'     => 'permit_empty'
			],
			'role'     => [
				'label'     => 'Role',
				'rules'     => 'required'
			],
		]);

		// Checking Validation
		if (!$rules) {
			session()->setFlashdata('failed', $this->validation->listErrors());
			return redirect()->to(BASE_URL . 'hedgefund/auth/register')->withInput();
		}

		// Initial Data
		$referral = htmlspecialchars($this->request->getVar('referral'));
		$mdata = [
			'email'         => htmlspecialchars($this->request->getVar('email')),
			'password'      => sha1(htmlspecialchars($this->request->getVar('pass'))),
			'timezone'      => htmlspecialchars($this->request->getVar('timezone')),
			'referral'      => !empty($referral) ? $referral : null,
			'role'          => htmlspecialchars($this->request->getVar('role')),
			'ip_address'    => htmlspecialchars($this->request->getIPAddress()),
		];

		$tempUser = (object)[
			'email'  => htmlspecialchars($this->request->getVar('email')),
			'passwd' => sha1($this->request->getVar('pass'))
		];
		session()->set('reg_user', $tempUser);


		$url = URL_HEDGEFUND . "/auth/register";
		$result = satoshiAdmin($url, json_encode($mdata))->result;

		// Check if the result code is not 201
		if ($result->code != '201') {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'hedgefund/auth/register')->withInput();
		} else {
			$subject = "Activation Account - HEDGE FUND";
			sendmail_satoshi($mdata['email'], $subject,  emailtemplate_activation_account($result->message->otp, $mdata['email'], "HEDGE FUND", 'hedgefund/auth/forgot_pass_otp/'), "HEDGE FUND", USERNAME_MAIL);
			return redirect()->to(BASE_URL . 'hedgefund/auth/otp/' . base64_encode($mdata['email']));
		}
	}


	public function login()
	{

		if (session()->get('logged_user')) {
			return redirect()->to(BASE_URL . 'hedgefund/dashboard');
		}
		$this->session->remove('reg_user');
		$mdata = [
			'title'     => 'Login - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/login',
			'extra'     => 'hedgefund/subscription/js/_js_login',
			// 'navoption' => true,
			// 'darkNav'   => true,
			// 'footer'    => false,
			// 'nav'       => false,
		];

		return view('hedgefund/layout/wrapper', $mdata);
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
			return redirect()->to(BASE_URL . 'hedgefund/auth/login')->withInput();
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

		// $tempUser = (object)[
		// 	'email'  => htmlspecialchars($this->request->getVar('email')),
		// 	'passwd' => sha1($this->request->getVar('password'))
		// ];
		// session()->set('logged_user', $tempUser);

		// Proccess Endpoin API
		$url = URL_HEDGEFUND . "/auth/signin";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 200) {
			$loggedUser = $result->message;

			if (in_array($loggedUser->role, ['member', 'referral', 'superadmin'])) {
				session()->set('logged_user', $loggedUser);
				return redirect()->to(BASE_URL . 'hedgefund/dashboard');
			}

			session()->setFlashdata('failed', 'Access Denied');
		} else {
			$message = $result->message ?? 'Login failed, please try again';
			// Jika akun belum diaktivasi
			if (strpos(strtolower($message), 'your account has not been activated') !== false) {
				// Redirect ke halaman OTP
				$encodedEmail = base64_encode($email);
				return redirect()->to(BASE_URL . "hedgefund/auth/otp/" . $encodedEmail . "?r=1")
					->with('success', 'Your account is not activated. Please enter the OTP sent to your email.');
			}
			// Jika error lain
			return redirect()->to(BASE_URL . 'hedgefund/auth/login')->with('failed', $message);
		}

		return redirect()->to(BASE_URL . 'hedgefund/auth/login');
	}


	public function otp($email = null)
	{
		if ($email === null) {
			return redirect()->to('auth/index');
		}
		$email = urldecode($email);

		$mdata = [
			'title'     => 'OTP - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/otp',
			'extra'     => 'hedgefund/subscription/js/_js_otp',
			'emailuser' => $email,

			// 'navoption' => true,
			// 'darkNav'   => true,
			// 'footer'    => false,
			// 'nav'       => false,
		];

		return view('hedgefund/layout/wrapper', $mdata);
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
			$url = URL_HEDGEFUND . "/auth/activate_member";
			$response = satoshiAdmin($url, json_encode($mdata));

			return $this->response->setJSON([
				'code' => $response->result->code ?? 400,
				'message' => $response->result->message ?? 'Failed to process request'
			]);
		} catch (\Exception $e) {
			log_message('error', 'OTP Processing Error: ' . $e->getMessage());
			return $this->response->setJSON([
				'code' => 500,
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

	public function set_capital()
	{
		// $data=(object)array(
		//         "email" => "a@a.a",
		//         "passwd"=> sha1(123)
		//     );
		//    $_SESSION["reg_user"]=$data;
		$methodPayment = $this->request->getGet('method');

		$mdata = [
			'title'     => 'Capital - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/set_capital',
			'extra'     => 'hedgefund/subscription/js/_js_capital_investment',
			'methodPayment' => $methodPayment,
			// 'navoption' => true,
			// 'darkNav'   => true,
			// 'footer'    => false,
			// 'nav'       => false,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	public function get_investment_config()
	{
		$url = URL_HEDGEFUND . "/price";
		$result = satoshiAdmin($url)->result;
		$minCapital = (float) $result->message->price;
		$fee        = (float) $result->message->cost;
		$commission = (float) $result->message->referral_fee;
		$step       = (float) $result->message->step;
		log_message('debug', 'API Price: ' . $minCapital . ', Commission: ' . $commission);

		$data = [
			'min_capital'       => $minCapital,
			'additional_step'   => 500,
			'percentage_fee'    => $fee,
			'comission'         => $commission,
		];

		return $this->response->setJSON($data);
	}

	public function save_payment_to_session()
	{
		try {
			$url = URL_HEDGEFUND . "/price";
			$result = satoshiAdmin($url)->result;
			$minCapital = (float) $result->message->price;
			$fee        = (float) $result->message->cost;
			$commission = (float) $result->message->referral_fee;
			$totalCapital =  $this->request->getPost('totalcapital');
			$amount = $this->request->getPost('amount');
			$payment_amount = ceil(($totalCapital + 10 + ceil($totalCapital * $commission)) * (1 + $fee));

			// Validate
			if ($totalCapital < $minCapital) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Amount must not be less than the minimum capital of ' . number_format($minCapital, 0)
				])->setStatusCode(400);
			}

			if ($amount != $payment_amount) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Payment amount does not match the required value'
				])->setStatusCode(400);
			}

			// Simpan data ke dalam session
			$paymentData = [
				'amount' => $this->request->getPost('amount'),
				'totalcapital' => $this->request->getPost('totalcapital'),
				'timestamp' => date('Y-m-d H:i:s')
			];

			$session = session();
			$session->set('payment_data', $paymentData);

			return $this->response->setJSON([
				'status' => 'success',
				'message' => 'Payment data saved successfully',
				'data' => $paymentData
			]);
		} catch (\Exception $e) {
			log_message('error', 'Exception: ' . $e->getMessage());
			return $this->response->setJSON([
				'status' => 'error',
				'message' => '<p>An internal error occurred:</p><p>' . $e->getMessage() . '</p><p>Please try again later or contact customer support.</p>'
			])->setStatusCode(500);
		}
	}


	public function payment_option()
	{
		$mdata = [
			'title'     => 'Payment Option - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/payment_option',
			'extra'     => 'hedgefund/subscription/js/_js_payment_option',
			// 'navoption' => true,
			// 'darkNav'   => true,
			'footer'    => false,
			'nav'       => false,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	function createCoinPaymentTransaction($amount, $currency, $invoiceNumber, $buyer_email, $description)
	{
		$publicKey  = COINPAYMENTS_PUBLIC_KEY;
		$privateKey = COINPAYMENTS_PRIVATE_KEY;
		$url = COINPAYMENTS_API_URL; // use actual API URL
		$nonce = get_coinpayments_nonce();

		$payload = [
			'cmd'        => 'create_transaction',
			'amount'     => $amount,
			'currency1'  => 'USD',
			'currency2'  => $currency,
			'invoice'    => $invoiceNumber,
			'buyer_email' => $buyer_email,
			'item_name'  => $description,
			'key'        => $publicKey,
			'ipn_url'    => base_url() . 'hedgefund/auth/coinpayment_notify',
			'success_url' => base_url() . 'hedgefund/auth/returncrypto',
			'cancel_url' => base_url() . "hedgefund/auth/set_capital",
			'version'    => 1,
			'format'     => 'json',
			'nonce'       => $nonce
		];

		$postData = http_build_query($payload, '', '&');
		$hmac = hash_hmac('sha512', $postData, $privateKey);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $hmac]);

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			return 'Curl error: ' . curl_error($ch);
		}

		curl_close($ch);
		return json_decode($response, true);
	}

	public function coinpayment_notify()
	{
		$data = $_POST;
		log_message('error', "data cointpayment : " . json_encode($data));

		if ($data["status"] === "100") {
			$merchantOrderId = $data['invoice'] ?? null;
			$reference = $data['txn_id'] ?? null;

			// Callback tervalidasi
			$code = "pending";
			if ($data['status_text'] == 'Complete') {
				$code = "complete";
			} elseif ($data['status_text'] == 'Failed') {
				$code = "failed";
			}

			$postData = array(
				"invoice"   => $merchantOrderId,
				"references" => $reference,
				"status"    => $code
			);
			// Debugging sebelum kirim request

			log_message('error', "Sending data" . json_encode($postData));

			$url = URL_HEDGEFUND . "/non/notify_payment";
			$response = satoshiAdmin($url, json_encode($postData));
			log_message('error', "Response: " . json_encode($response));
		}
	}

	public function returncrypto()
	{
		$this->session->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
		return redirect()->to(base_url() . 'hedgefund/auth/payment_option');
	}

	/* 
	Payment Lama
	public function usdt_payment()
	{
		$payamount  = $_SESSION["payment_data"]["amount"];
		$customerEmail = $_SESSION["reg_user"]->email;
		$postData = [
			'email' => $customerEmail,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];

		$url        = URL_HEDGEFUND . "/non/deposit";
		$invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
		$orderId    = $invoice;
		$description = "HEDGE FUND - PNGLOBAL";
		//USDT.BEP20
		$paymentResponse = $this->createCoinPaymentTransaction($payamount, COINPAYMENTS_CURRENCY_USDT, $orderId, $customerEmail, $description);
		if ($paymentResponse['error'] !== 'ok') {
			$this->session->setFlashdata('failed', 'There was a problem processing your purchase please try again');
			return redirect()->to(base_url() . 'hedgefund/auth/set_capital');
		}

		return redirect()->to($paymentResponse['result']['checkout_url']);
	}

	public function usdc_payment()
	{
		$payamount  = $_SESSION["payment_data"]["amount"];
		$customerEmail = $_SESSION["reg_user"]->email;
		$postData = [
			'email' => $customerEmail,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];

		$url        = URL_HEDGEFUND . "/non/deposit";
		$invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
		$orderId    = $invoice;
		$description = "HEDGE FUND - PNGLOBAL";
		// 'USDC.BEP20'

		$paymentResponse = $this->createCoinPaymentTransaction($payamount, COINPAYMENTS_CURRENCY_USDC, $orderId, $customerEmail, $description);
		if ($paymentResponse['error'] !== 'ok') {
			$this->session->setFlashdata('failed', 'There was a problem processing your purchase please try again');
			return redirect()->to(base_url() . 'hedgefund/auth/set_capital');
		}

		return redirect()->to($paymentResponse['result']['checkout_url']);
	}
	*/

	public function forgot_password()
	{
		$mdata = [
			'title'     => 'Reset Password - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/forgot_password',
			'extra'     => 'hedgefund/subscription/js/_js_forgot_password',
		];

		return view('member/layout/login_wrapper', $mdata);
	}

	public function check_wallet_hedgefund()
	{
		// Ambil data POST JSON dari request
		$data = $this->request->getJSON();
		$email = $data->email ?? null;   // email dikirim dari JS
		$type  = $data->type  ?? 'hedgefund'; // default type

		// Panggil API internal/remote untuk cek wallet
		$url = URL_HEDGEFUND . "/auth/check_wallet";
		$response = satoshiAdmin($url, json_encode(['email' => $email, 'type' => $type]));

		return $this->response->setJSON($response->result);
	}

	public function create_wallet_hedgefund()
	{
		$data = $this->request->getJSON();
		$email = $data->email ?? null;   // email dikirim dari JS
		$type  = $data->type  ?? 'hedgefund'; // default type

		$url = URL_HEDGEFUND . "/auth/create_wallet";
		$response = satoshiAdmin($url, json_encode(['email' => $email, 'type' => $type]))->result;
		return $this->response->setJSON($response);
	}

	public function usdt_payment()
	{
		$payamount  = $_SESSION["payment_data"]["amount"];
		$email = session()->get('reg_user')->email ?? null;

		$mdata = [
			'title'     => 'USDT Network - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/crypto_wallet_option',
			'extra'     => 'hedgefund/subscription/js/_js_crypto_wallet_option',
			'email'     => $email,
			'payamount' => $payamount,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	public function usdc_payment()
	{
		$payamount  = $_SESSION["payment_data"]["amount"];
		$email = session()->get('reg_user')->email ?? null;

		$mdata = [
			'title'     => 'USDC Network - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/crypto_wallet_option',
			'extra'     => 'hedgefund/subscription/js/_js_crypto_wallet_option',
			'email'     => $email,
			'payamount' => $payamount,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}
	
	public function deposit_payment($type, $network = null)
	{
		$type = strtoupper($type);
		$networkType = $network; // enum('erc20','bep20','polygon','trc20','base','solana')
		$email = session()->get('reg_user')->email ?? null;

		$payamount  = $_SESSION["payment_data"]["amount"];
		$totalCapital = $_SESSION["payment_data"]["totalcapital"];
		$fee = $payamount - $totalCapital;

		// Generate Invoice
		$postData = [
			'email' => $email,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];
		$url_deposit        = URL_HEDGEFUND . "/non/deposit";
		$invoice   = satoshiAdmin($url_deposit, json_encode($postData))->result->message;
		$orderId    = $invoice;

		// Cek wallet
		$url = URL_HEDGEFUND . "/auth/get_crypto_wallet";
		$wallet = satoshiAdmin($url, json_encode(['type' => "hedgefund", 'network' => $networkType, 'email' => $email]));


		if (isset($wallet->result->code) && $wallet->result->code == 200) {
			// Wallet ditemukan, tampilkan halaman deposit
			$mdata = [
				'title'      => 'Payment Crypto - ' . NAMETITLE,
				'content'    => 'hedgefund/subscription/register_deposit_crypto',
				'extra'      => 'hedgefund/subscription/js/_js_deposit_crypto',
				'type'       => $type,
				'network'    => $networkType,
				'wallet'     => $wallet->result->message,
				'payamount'  => $payamount,
				'total'      => $totalCapital,
				'fee'        => $fee,
				'order_id'   => $orderId,
			];

			return view('hedgefund/layout/wrapper', $mdata);
		} else {
			// Wallet tidak ditemukan, redirect ke halaman sebelumnya
			return redirect()->back()->with('error', 'Wallet tidak ditemukan, silakan buat wallet terlebih dahulu.');
		}
	}

	public function us_bank_payment()
	{
		// Ambil data bank dan fee setting
		$url   = URL_HEDGEFUND . "/non/us-bank";
		$bank  = satoshiAdmin($url);
		$feebank = $bank->result->data->us_bank_fee_setting;

		// Ambil data pembayaran dari session
		$payamount     = $_SESSION["payment_data"]["amount"];
		$customerEmail = $_SESSION["reg_user"]->email;

		// Siapkan data untuk generate invoice
		$postData = [
			'email'  => $customerEmail,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];

		// Buat invoice
		$urlInvoice = URL_HEDGEFUND . "/non/deposit";
		$invoice    = satoshiAdmin($urlInvoice, json_encode($postData))->result->message;
		$orderId    = $invoice;

		// Hitung total payment (amount + fee bank)
		$total      = $payamount + $feebank;

		// Data untuk dikirim ke view
		$mdata = [
			'title'      => 'Capital - ' . NAMETITLE,
			'content'    => 'hedgefund/subscription/register_deposit_us_bank',
			'extra'      => 'hedgefund/subscription/js/_js_register_deposit_us_bank',
			'order_id'   => $orderId,
			'payamount'  => $payamount,
			'bank'       => $bank->result->data,
			'total'      => $total,
			'fee'        => $feebank,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	public function international_bank_payment()
	{
		// Ambil data bank dan fee setting
		$url   = URL_HEDGEFUND . "/non/international-bank";
		$bank  = satoshiAdmin($url);
		$feebank = $bank->result->data->inter_fee_setting;

		// Ambil data pembayaran dari session
		$payamount     = $_SESSION["payment_data"]["amount"];
		$customerEmail = $_SESSION["reg_user"]->email;

		// Siapkan data untuk generate invoice
		$postData = [
			'email'  => $customerEmail,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];

		// Buat invoice
		$urlInvoice = URL_HEDGEFUND . "/non/deposit";
		$invoice    = satoshiAdmin($urlInvoice, json_encode($postData))->result->message;
		$orderId    = $invoice;

		// Hitung total payment (amount + fee bank)
		$total      = $payamount + $feebank;

		// Data untuk dikirim ke view
		$mdata = [
			'title'      => 'Capital - ' . NAMETITLE,
			'content'    => 'hedgefund/subscription/register_deposit_international_bank',
			'extra'      => 'hedgefund/subscription/js/_js_register_deposit_us_bank',
			'order_id'   => $orderId,
			'payamount'  => $payamount,
			'bank'       => $bank->result->data,
			'total'      => $total,
			'fee'        => $feebank,
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	/*	public function pricing()
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
			'title'     => 'Subscription - ' . 	NAMETITLE,
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
			'title'     => 'Active Account - ' . NAMETITLE,
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
			'title'     => 'Active Account - ' . NAMETITLE,
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];

		return view('widget/layout/wrapper', $mdata);
	}*/

	/*	public function send_activation($email, $token)
	{
		$email = urldecode($email);
		$subject =  NAMETITLE . " - Activation Account";


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
*/
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
			return redirect()->to(BASE_URL . 'hedgefund/auth/forgot_password')->withInput();
		}

		$email = $this->request->getVar('email');
		$subject = 	NAMETITLE . " - Reset Password";


		// Call API
		$url = URL_HEDGEFUND . "/auth/resend_token";
		$resultMember = satoshiAdmin($url, json_encode(['email' => $email]));
		$response = $resultMember->result ?? null;
		// Tangani jika response gagal (validasi atau email tidak ditemukan)
		if (isset($response->code) && $response->code == 400) {
			// Ambil pesan error dari messages (bisa 'email' atau 'error')
			$errorMsg = '';
			if (isset($response->message)) {
				$errorMsg = $response->message;
			}

			session()->setFlashdata('failed', $errorMsg ?: 'Gagal mengirim reset password');
			return redirect()->to(BASE_URL . 'hedgefund/auth/forgot_password')->withInput();
		}

		// Tangani jika sukses
		$messageText = $response->message->text ?? '';
		$otp = $response->message->otp ?? '';

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
						Thank you for using Hedge Fund App. To proceed with your request, please copy token reset password below 
					</p>
					<h2 id='copyToken'>
						" . $otp . "
					</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						Hedge Fund Team

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
		// session()->setFlashdata('success', $messageText);
		return redirect()->to(BASE_URL . 'hedgefund/auth/forgot_pass_otp/' . base64_encode($email))->with('success', $messageText);
	}

	public function forgot_pass_otp($emailuser)
	{
		// $emailuser = urldecode($emailuser);

		$mdata = [
			'title'     => 'Forgot Password - Satoshi Signal',
			'content'   => 'hedgefund/subscription/otp_reset_password',
			'extra'     => 'hedgefund/subscription/js/_js_otp_reset_password',
			'emailuser' => $emailuser
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}

	public function reset_password_confirmation()
	{
		$email = $this->request->getPost('email') ?? old('email');
		$otp   = $this->request->getPost('otp') ?? old('otp');

		// dd($email, $otp);

		if (empty($email) || empty($otp)) {
			session()->setFlashdata('failed', 'Email atau OTP tidak ditemukan.');
			return redirect()->to(BASE_URL . 'hedgefund/auth/forgot_pass_otp/' . base64_encode($email));
		}

		if (!$this->checkotp($email, $otp)) {
			session()->setFlashdata('failed', 'Invalid token');
			return redirect()->to(BASE_URL . 'hedgefund/auth/forgot_pass_otp/' . base64_encode($email));
		};

		$mdata = [
			'title' => 'Reset Password Confirmation',
			'content' => 'hedgefund/subscription/reset_password_confirmation',
			'extra' => 'hedgefund/subscription/js/_js_reset_password_confirmation',
			'email' => $email,
			'otp'   => $otp
		];

		return view('hedgefund/layout/login_wrapper', $mdata);
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
			return redirect()->to(BASE_URL . 'hedgefund/auth/reset_password_confirmation/')->withInput();
		}

		$email = $this->request->getPost('email');
		$otp   = $this->request->getPost('otp');
		$password = $this->request->getPost('password');

		$mdata = [
			'email' => $email,
			'otp'   => $otp,
			'password' => sha1($password)
		];

		$url = URL_HEDGEFUND . "/auth/reset_password";
		$response = satoshiAdmin($url, json_encode($mdata));
		$result = $response->result;

		if ($result->code == 200) {
			session()->setFlashdata('success', 'Password berhasil diubah.');
			return redirect()->to(BASE_URL . 'hedgefund/auth/login');
		} else {
			session()->setFlashdata('failed', $result->message);
			return redirect()->to(BASE_URL . 'hedgefund/auth/reset_password_confirmation/')->withInput();
		}
	}



	public function logout()
	{
		$this->session->remove('logged_user');
		return redirect()->to(BASE_URL . 'hedgefund/auth/login');
	}

	private function checkotp($email, $otp)
	{
		$url = URL_HEDGEFUND . "/auth/otp_check";
		$response = courseAdmin($url, json_encode([
			'email' => $email,
			'otp'   => $otp
		]));

		return isset($response->result->code, $response->result->message)
			&& $response->result->code == 200
			&& $response->result->message == true;
	}

	public function resend_token($email)
	{
		$msg = [
			'success' => false,
			'message' => 'Failed to resend activation code.'
		];
		$url = URL_HEDGEFUND . "/auth/resend_token";

		$response = satoshiAdmin($url, json_encode(['email' => $email]));
		$result = $response->result;

		if (($result->code ?? $response->status) == 200) {
			$msg = [
				'success' => true,
				'message' => $result->message->text
			];


			$subject = 	NAMETITLE . " - Reset Password";
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
						Thank you for using Hedge Fund App. To proceed with your request, please copy token reset password below 
					</p>
					<h2 id='copyToken'>
						" . $result->message->otp . "
					</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						Hedge Fund Team

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
		}

		return $this->response->setJSON($msg);
	}

	public function bank_payment()
	{
		// dd(session()->get());
		if (!session()->has('reg_user')) {
			session()->destroy();
			return redirect()->to(base_url('hedgefund/auth/login'));
		}

		$payamount  = $_SESSION["payment_data"]["amount"];
		$customerEmail = $_SESSION["reg_user"]->email;
		$postData = [
			'email' => $customerEmail,
			'amount' => $_SESSION["payment_data"]["totalcapital"],
		];

		$url        = URL_HEDGEFUND . "/non/deposit";
		$invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
		$orderId    = $invoice;
		$description = "HEDGE FUND - PNGLOBAL";


		// Simpan data ke session
		session()->set([
			'bank_payment_order_id' => $orderId,
			'bank_payment_amount'   => $payamount
		]);

		// Redirect ke halaman info deposit bank
		return redirect()->to(BASE_URL . 'hedgefund/auth/deposit_bank_transaction');
	}

	public function deposit_bank_transaction()
	{
		$orderId  = session()->get('bank_payment_order_id');
		$payamount = session()->get('bank_payment_amount');
		$fee       = 50;
		$total     = $payamount + $fee;

		$url = URL_HEDGEFUND . "/non/bank";
		$result = satoshiAdmin($url);

		$mdata = [
			'title'     => 'Elite Management - ' . NAMETITLE,
			'content'   => 'hedgefund/subscription/bank_payment',
			'extra'     => 'hedgefund/subscription/js/_js_bank_payment',
			'order_id'       => $orderId,
			'payamount'      => $payamount,
			'fee'            => $fee,
			'total'          => $total,
			'bank'           => @$result->result->data
		];

		return view('hedgefund/layout/wrapper', $mdata);
	}
}
