<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        //total student
        $url = URL_COURSE ."";
        $resultstudent= 10;

        //total mentor
        $url = URL_COURSE ."";
        $resultmentor = 5;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/course/dashboard/index',
            'extra'     => 'godmode/course/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalstudent'   => $resultstudent,
            'totalmentor'    => $resultmentor,
            'payment_link'  => session()->getFlashdata('paymentlink')

        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function paymentlink(){
                // Validation Field
        $rules = $this->validate([
            'nominal' => [
                'label' => 'Nominal',
                'rules' => 'required|decimal'
            ],
            'currency' => [
                'label' => 'Currency',
                'rules' => 'required|in_list[usdt,usdc,stripe,banktransfer]'
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/dashboard');
        }

        // Ambil nilai dari input
        $nominal     = htmlspecialchars($this->request->getVar('nominal'));
        $currency    = $this->request->getVar('currency');
        $description = htmlspecialchars($this->request->getVar('description'));
        
        $mdata=array(
                "amount"       => $nominal,
                "currency"      => in_array($currency, ['usdt', 'usdc']) ? $currency . '.bep20' : $currency,
                "buyer_email"   => 'kkn5pw5w25@qacmjeq.com',
                "description"   => $description ?: 'Course Payment',
                "invoiceNumber" => 'INV-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 6))
        );

        switch ($currency) {
            case 'usdt':
            case 'usdc':
                $paymentResponse = $this->createCoinPaymentTransaction($mdata);
                if ($paymentResponse['error'] !== 'ok') {
                    session()->setFlashdata('failed', 'There was a problem processing your purchase please try again');
                    return redirect()->to(BASE_URL . 'godmode/course/dashboard')->withInput();
                }

                session()->setFlashdata('paymentlink', $paymentResponse['result']['checkout_url']);
                return redirect()->to(BASE_URL . 'godmode/course/dashboard')->withInput();
            case 'stripe':
                $stripeUrl = $this->createStripePayment($mdata);
                if (!$stripeUrl) {
                    return redirect()->to(base_url('godmode/course/dashboard'))->withInput();
                }
                session()->setFlashdata('paymentlink', $stripeUrl);
                return redirect()->to(BASE_URL .  'godmode/course/dashboard')->withInput();

            case 'banktransfer':
                session()->setFlashdata('paymentlink', 123);
                return redirect()->to(BASE_URL . 'godmode/course/dashboard')->withInput();
        }

    }

    function createCoinPaymentTransaction($mdata)
    {
        $publicKey  = COINPAYMENTS_PUBLIC_KEY;
        $privateKey = COINPAYMENTS_PRIVATE_KEY;
        $url = COINPAYMENTS_API_URL; // use actual API URL
        $nonce = get_coinpayments_nonce();

        $payload = [
            'cmd'        => 'create_transaction',
            'amount'     => $mdata['amount'],
            'currency1'  => 'USD',
            'currency2'  => strtoupper($mdata['currency']),
            'invoice'    => $mdata['invoiceNumber'],
            'buyer_email'=> $mdata['buyer_email'],
            'item_name'  => $mdata['description'],
            'key'        => $publicKey,
            'ipn_url'    => base_url().'course/auth/coinpayment_notify',
            'success_url'=> base_url().'course/login/member',
            'cancel_url' => base_url().'course/login/member',
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
        log_message('error',"COIN PAYMENT". json_encode($response));
        return json_decode($response, true);

    }    

    public function createStripePayment($mdata)
    {
        \Stripe\Stripe::setApiKey(SECRET_KEY);
    
        try {
            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'], // atau ['card', 'us_bank_account', etc]
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $mdata['description'],
                        ],
                        'unit_amount' => intval(floatval($mdata['amount']) * 100), // dalam sen. Misal €10 = 1000
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $mdata['buyer_email'],
                'invoice_creation' => ['enabled' => true],
                'success_url'=> base_url().'course/login/member',
                'cancel_url' => base_url().'course/login/member'
            ]);
    
            return $checkoutSession->url;
    
        } catch (\Exception $e) {
            session()->setFlashdata('failed', 'Stripe error: ' . $e->getMessage());
            return null;
        }
    }
    
}
