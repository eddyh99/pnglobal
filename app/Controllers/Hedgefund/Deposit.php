<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Deposit extends BaseController
{

    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if (!in_array($loggedUser->role, ['member', 'referral', 'superadmin'])) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        // if($loggedUser->role == 'referral') {
        //     throw PageNotFoundException::forPageNotFound();
        // }
    }

    public function index()
    {
        $methodPayment = $this->request->getGet('method');
        // Jika tidak ada metode pembayaran yang dipilih return ke halaman sebelumnya
        if (!$methodPayment) {
            $previous = $this->request->getServer('HTTP_REFERER');
            if ($previous) {
                return redirect()->to($previous);
            } else {
                return redirect()->to(BASE_URL . 'hedgefund/deposit/option');
            }
        }

        $role = $_SESSION["logged_user"]->role;
        $mdata = [
            'title'     => 'Deposit - ' . NAMETITLE,
            'content'   => ($role == "superadmin") ? 'hedgefund/deposit/admin_capital' : 'hedgefund/deposit/set_capital',
            'extra'     => 'hedgefund/deposit/js/_js_capital_investment',
            'active_deposit'    => 'active',
            'methodPayment'  => $methodPayment,
        ];
        return view('hedgefund/layout/dashboard_wrapper', $mdata);
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
            'additional_step'   => $step,
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
                'amount' => $amount,
                'totalcapital' => $totalCapital,
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

    public function add_deposit()
    {
        // Validation Field
        $rules = $this->validate([
            'amount' => [
                'label' => 'Amount',
                'rules' => 'required|greater_than[0]'
            ],
        ]);


        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'hedgefund/deposit')->withInput();
        }

        $amount = $this->request->getVar('amount');
        $url = URL_HEDGEFUND . '/v1/member/admin_deposit';
        $result = satoshiAdmin($url, json_encode(['amount' => $amount]))->result;

        if (@$result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'hedgefund/deposit');
        }

        session()->setFlashdata('success', 'Deposit is successfully added');
        return redirect()->to(BASE_URL . 'hedgefund/deposit');
    }


    public function option()
    {
        $mdata = [
            'title'     => 'Payment Option - ' . NAMETITLE,
            'content'   => 'hedgefund/deposit/payment_option',
            'extra'     => 'hedgefund/deposit/js/_js_payment_option',
            'active_deposit'    => 'active',
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    function createCoinPaymentTransaction($amount, $currency, $invoiceNumber, $buyer_email, $description)
    {
        $publicKey  = COINPAYMENTS_PUBLIC_KEY;
        $privateKey = COINPAYMENTS_PRIVATE_KEY;
        $url        = COINPAYMENTS_API_URL;
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
            'success_url' => base_url() . 'hedgefund/deposit/returncrypto',
            'cancel_url' => base_url() . "elite/deposit/set_capital",
            'version'    => 1,
            'format'     => 'json', // Ensure JSON response
            'nonce'      => $nonce
        ];

        // Generate HMAC signature
        $postData = http_build_query($payload, '', '&');
        $hmac = hash_hmac('sha512', $postData, $privateKey);

        // Send request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $hmac]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function returncrypto()
    {
        $this->session->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
        return redirect()->to(base_url() . 'hedgefund/auth/payment_option');
    }

    /* OLD FUNCTIONS - IGNORE
    public function usdt_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $customerId = $_SESSION["logged_user"]->id;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
            'member_id' => $customerId
        ];

        $url        = URL_HEDGEFUND . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;
        $description = "ELITE BTC MANAGEMENT";
        $paymentResponse = $this->createCoinPaymentTransaction($payamount, COINPAYMENTS_CURRENCY_USDT, $orderId, $customerEmail, $description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('failed', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url() . 'hedgefund/deposit');
        }

        return redirect()->to($paymentResponse['result']['checkout_url']);
    }

    public function usdc_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $customerId = $_SESSION["logged_user"]->id;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
            'member_id' => $customerId
        ];

        $url        = URL_HEDGEFUND . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;
        $description = "ELITE BTC MANAGEMENT";

        $paymentResponse = $this->createCoinPaymentTransaction($payamount, COINPAYMENTS_CURRENCY_USDC, $orderId, $customerEmail, $description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('failed', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url() . 'hedgefund/deposit');
        }

        return redirect()->to($paymentResponse['result']['checkout_url']);
    }
    */

    public function get_history()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . '/v1/member/history_deposit?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function us_bank_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $customerId = $_SESSION["logged_user"]->id;
        $payment_type = 'us_bank';

        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
            'member_id' => $customerId,
            'payment_type' => $payment_type
        ];

        $url        = URL_HEDGEFUND . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;

        // Simpan data ke session
        session()->set([
            'bank_payment_order_id' => $orderId,
            'bank_payment_amount'   => $payamount
        ]);

        // Redirect ke halaman information deposit us bank
        return redirect()->to(BASE_URL . 'hedgefund/deposit/us_bank');
    }

    public function us_bank()
    {
        // Cek apakah session deposit tersedia
        if (!session()->has('bank_payment_order_id') || !session()->has('bank_payment_amount')) {
            // Kalau tidak ada, redirect ke halaman deposit utama
            return redirect()->to(BASE_URL . 'hedgefund/deposit');
        }

        $url = URL_HEDGEFUND . "/non/us-bank";
        $bank = satoshiAdmin($url);
        $feebank = $bank->result->data->us_bank_fee_setting;

        // dd($feebank);

        $orderId  = session()->get('bank_payment_order_id');
        $payamount = session()->get('bank_payment_amount');
        $total     = $payamount + $feebank;

        $mdata = [
            'title'          => 'Deposit Bank - ' . NAMETITLE,
            'content'        => 'hedgefund/deposit/deposit_us_bank',
            'extra'          => 'hedgefund/deposit/js/_js_deposit_us_bank',
            'active_deposit' => 'active',
            'order_id'       => $orderId,
            'payamount'      => $payamount,
            'fee'            => $feebank,
            'total'          => $total,
            'bank'           => $bank->result->data
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function international_bank_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $customerId = $_SESSION["logged_user"]->id;
        $payment_type = 'international_bank';
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
            'member_id' => $customerId,
            'payment_type' => $payment_type
        ];

        $url        = URL_HEDGEFUND . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;

        // Simpan data ke session
        session()->set([
            'bank_payment_order_id' => $orderId,
            'bank_payment_amount'   => $payamount
        ]);

        // Redirect ke halaman information deposit inter bank
        return redirect()->to(BASE_URL . 'hedgefund/deposit/inter_bank');
    }

    public function inter_bank()
    {
        // Cek apakah session deposit tersedia
        if (!session()->has('bank_payment_order_id') || !session()->has('bank_payment_amount')) {
            // Kalau tidak ada, redirect ke halaman deposit utama
            return redirect()->to(BASE_URL . 'hedgefund/deposit');
        }

        $url = URL_HEDGEFUND . "/non/international-bank";
        $bank = satoshiAdmin($url);
        $feebank = $bank->result->data->inter_fee_setting;

        // dd($feebank);

        $orderId  = session()->get('bank_payment_order_id');
        $payamount = session()->get('bank_payment_amount');
        $total     = $payamount + $feebank;

        $mdata = [
            'title'          => 'Deposit Bank - ' . NAMETITLE,
            'content'        => 'hedgefund/deposit/deposit_inter_bank',
            'extra'          => 'hedgefund/deposit/js/_js_deposit_us_bank',
            'active_deposit' => 'active',
            'order_id'       => $orderId,
            'payamount'      => $payamount,
            'fee'            => $feebank,
            'total'          => $total,
            'bank'           => $bank->result->data
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
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
            'title'          => 'Deposit Bank - ' . NAMETITLE,
            'content'        => 'hedgefund/deposit/deposit_bank',
            'extra'          => 'hedgefund/deposit/js/_js_deposit_bank',
            'active_deposit' => 'active',
            'order_id'       => $orderId,
            'payamount'      => $payamount,
            'fee'            => $fee,
            'total'          => $total,
            'bank'           => @$result->result->data
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function usdt_payment()
    {
        $method_payment = 'usdt';
        $email = $_SESSION['logged_user']->email;

        $mdata = [
            'title'     => 'Option Network- ' . NAMETITLE,
            'content'   => 'hedgefund/deposit/crypto_wallet_option',
            'extra'     => 'hedgefund/deposit/js/_js_crypto_wallet_option',
            'active_deposit'    => 'active',
            'method_payment'  => $method_payment,
            'email' => $email
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function usdc_payment()
    {
        $method_payment = 'usdc';
        $email = $_SESSION['logged_user']->email;

        $mdata = [
            'title'     => 'Option Network- ' . NAMETITLE,
            'content'   => 'hedgefund/deposit/crypto_wallet_option',
            'extra'     => 'hedgefund/deposit/js/_js_crypto_wallet_option',
            'active_deposit'    => 'active',
            'method_payment'  => $method_payment,
            'email' => $email
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function crypto_wallet($method_payment, $network)
    {
        // =========================
        // 1. Pastikan session tersedia
        // =========================
        if (!session()->has('payment_data')) {
            return redirect()->to(BASE_URL . 'hedgefund/deposit');
        }

        $paymentData = $_SESSION["payment_data"];
        $payAmount    = $paymentData["amount"];
        $totalCapital = $paymentData["totalcapital"];
        $fee          = $payAmount - $totalCapital;

        $type         = strtoupper($method_payment); // usdt / usdc
        $networkType  = $network;
        $cointNetwork = strtolower($type . '_' . $networkType); // contoh: usdt_bep20, usdc_erc20
        $email        = session()->get('logged_user')->email ?? null;

        // =========================
        // 2. Generate invoice baru jika metode berbeda atau belum ada
        // =========================
        $prevInvoice  = $paymentData["order_id"] ?? null;
        $prevNetwork  = $paymentData["coint_network"] ?? null;

        if (!$prevInvoice || $prevNetwork !== $cointNetwork) {
            $postData = [
                'email'        => $email,
                'amount'       => $totalCapital,
                'payment_type' => $cointNetwork,
            ];

            $urlDeposit = URL_HEDGEFUND . "/non/deposit";
            $invoice    = satoshiAdmin($urlDeposit, json_encode($postData))->result->message;
            // Simpan invoice dan metode di session
            $_SESSION["payment_data"]["order_id"]      = $invoice;
            $_SESSION["payment_data"]["coint_network"] = $cointNetwork;
        } else {
            $invoice = $prevInvoice;
        }

        // =========================
        // 3. Ambil wallet crypto
        // =========================
        $urlWallet = URL_HEDGEFUND . "/auth/get_crypto_wallet";
        $wallet    = satoshiAdmin($urlWallet, json_encode([
            'type'    => "hedgefund",
            'network' => $networkType,
            'email'   => $email
        ]));

        // =========================
        // 4. Ambil balance wallet crypto di databse
        // =========================
        $urlBalanceWalletDb = URL_HEDGEFUND . "/non/crypto-balance-db-check";
        $balanceDBPayload = [
            'wallet_address' => $wallet->result->message->address,
            'token'          => $type, // usdt / usdc
            'network'        => $networkType // bep20 / erc20 / trc20 / polygon
        ];
        $wallet_db_balance    = satoshiAdmin($urlBalanceWalletDb, json_encode($balanceDBPayload));


        // =========================
        // 4. Siapkan data untuk view
        // =========================
        $viewData = [
            'title'          => 'Payment Option - ' . NAMETITLE,
            'content'        => 'hedgefund/deposit/deposit_crypto_wallet',
            'extra'          => 'hedgefund/deposit/js/_js_deposit_crypto_wallet',
            'active_deposit' => 'active',
            'method_payment' => $method_payment,
            'wallet'         => $wallet->result->message,
            'wallet_db_balance' => $wallet_db_balance->result->message->balance_db,
            'network'        => $networkType,
            'token'          => $type,
            'coint_network'  => $cointNetwork,
            'total_payamount'     => $payAmount,
            'total_capital'  => $totalCapital,
            'fee'            => $fee,
            'order_id'       => $invoice
        ];

        return view('hedgefund/layout/dashboard_wrapper', $viewData);
    }
}
