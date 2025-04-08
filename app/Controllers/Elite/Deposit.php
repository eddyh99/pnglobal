<?php

namespace App\Controllers\Elite;

use App\Controllers\BaseController;

class Deposit extends BaseController
{

    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }
    }

    public function index()
    {

        $mdata = [
            'title'     => 'Deposit - ' . NAMETITLE,
            'content'   => 'elite/deposit/set_capital',
            'extra'     => 'elite/deposit/js/_js_capital_investment',
            'active_deposit'    => 'active',
        ];
        return view('elite/layout/dashboard_wrapper', $mdata);
    }
    
    public function get_investment_config()
    {
        $url = URL_ELITE . "/v1/price";
        $result = satoshiAdmin($url)->result;
        $minCapital = (float) $result->message->price;
        $fee        = (float) $result->message->cost;
        $commission = (float) $result->message->referral_fee;

        log_message('debug', 'API Price: ' . $minCapital . ', Commission: ' . $commission);

        $data = [
            'min_capital'       => $minCapital,
            'additional_step'   => 2000,
            'percentage_fee'    => $fee,
            'comission'         => $commission,
        ];

        return $this->response->setJSON($data);
    }

    public function save_payment_to_session()
    {
        try {
            // Validasi request
            $rules = [
                'amount' => 'required|numeric|greater_than[0]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $this->validator->getErrors()
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
            'content'   => 'elite/deposit/payment_option',
            'extra'     => 'elite/deposit/js/_js_payment_option',
            'active_deposit'    => 'active',
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }
    
    function createCoinPaymentTransaction($amount, $currency, $invoiceNumber,$buyer_email,$description)
    {
        $publicKey  = "61b29c2e66e2720b3d4c2906df6e0fe61b3809094e94322f6a7da99bb5645aa9";
        $privateKey = "7eBb4a5fbb1F4A24dea25c58883d7A19ae111F5C822392dB352a2c2f8285703A";
        $url = 'https://www.coinpayments.net/api.php';
        $payload = [
                'cmd'        => 'create_transaction',
                'amount'     => $amount,
                'currency1'  => 'USD',
                'currency2'  => $currency,
                'invoice'    => $invoiceNumber,
                'buyer_email'=> $buyer_email,
                'item_name'  => $description,
                'key'        => $publicKey,
                'ipn_url'    => base_url().'elite/auth/coinpayment_notify',
                'success_url'=> base_url().'elite/deposit/returncrypto',
                'cancel_url' => base_url()."elite/deposit/set_capital",
                'version'    => 1,
                'format'     => 'json', // Ensure JSON response
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

    public function returncrypto(){
        $this->session->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
        return redirect()->to(base_url().'elite/auth/payment_option'); 
    }

    public function usdt_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
        ];

        $url        = URL_ELITE . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;
        $description= "ELITE BTC MANAGEMENT";

        $paymentResponse = $this->createCoinPaymentTransaction($payamount,'USDT.BEP20', $orderId,$customerEmail,$description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'elite/auth/set_capital'); 
        }
        
        return redirect()->to($paymentResponse['result']['checkout_url']); 
    }

    public function usdc_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $customerEmail = $_SESSION["logged_user"]->email;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
        ];

        $url        = URL_ELITE . "/non/deposit";
        $invoice   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $invoice;
        $description= "ELITE BTC MANAGEMENT";

        $paymentResponse = $this->createCoinPaymentTransaction($payamount,'USDC.BEP20', $orderId,$customerEmail,$description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'elite/auth/set_capital'); 
        }
        
        return redirect()->to($paymentResponse['result']['checkout_url']); 
    }

}
