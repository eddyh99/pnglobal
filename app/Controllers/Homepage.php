<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\GoogleCalendarService;
use DateTime;
use DateTimeZone;
use CodeIgniter\Validation\ValidationInterface;
use CodeIgniter\Session\SessionInterface;

class Homepage extends BaseController
{
    protected $googleCalendarService;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->googleCalendarService = new GoogleCalendarService();
        $this->validation = \Config\Services::validation();
        $this->session = \Config\Services::session();
    }

    public function index()
    {

        $mdata = [
            'title'     => 'Homepage - ' . NAMETITLE,
            'content'   => 'homepage/index',
            'extra'     => 'homepage/js/_js_index',
            'extragsap' => 'homepage/gsap/gsap_homepage',
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function about()
    {
        $mdata = [
            'title'     => 'About Team - ' . NAMETITLE,
            'content'   => 'homepage/about',
            'extra'     => 'homepage/js/_js_about',
            'extragsap' => 'homepage/gsap/gsap_about'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function comingsoon()
    {
        $mdata = [
            'title'     => 'Coming Soon - ' . NAMETITLE,
            'content'   => 'homepage/comingsoon',
            'extra'     => 'homepage/js/_js_index',
            'flag'      => 'comingsoon'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }



    public function service()
    {
        $service = base64_decode($_GET['service']);

        // if ($service == "finance_advice_investment") {
        //     $mdata = [
        //         'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
        //         'content'   => 'homepage/service/finance',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_finance',
        //     ];
        // } else if ($service == "strategic_optimization") {
        //     $mdata = [
        //         'title'     => 'Service Strategic And Tax Optimization - ' . NAMETITLE,
        //         'content'   => 'homepage/service/strategic',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_strategic'
        //     ];
        // } else if ($service == "international_expansion_management") {
        //     $mdata = [
        //         'title'     => 'Service International Expansion And Management - ' . NAMETITLE,
        //         'content'   => 'homepage/service/international',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_international'
        //     ];
        // } else if ($service == "legal_tax_accounting") {
        //     $mdata = [
        //         'title'     => 'Legal, Tax, And Accounting Advice - ' . NAMETITLE,
        //         'content'   => 'homepage/service/legal',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_legal'
        //     ];
        // } else if ($service == "professional_enterpreneurial_training") {
        //     $mdata = [
        //         'title'     => 'Service Professional Enterpreneurial Training - ' . NAMETITLE,
        //         'content'   => 'homepage/service/training',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_training',
        //         'flag'      => 'blockchain'
        //     ];
        // } else if ($service == "blockchain_mining_bitcoin_training") {
        //     $mdata = [
        //         'title'     => 'Advanced Training on Blockchain, Mining and Bitcoin - ' . NAMETITLE,
        //         'content'   => 'homepage/service/blockchain',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_blockchain',
        //         'flag'      => 'blockchain'
        //     ];
        // } else if ($service == "satoshi_signal") {
        //     $mdata = [
        //         'title'     => 'Bitcoin Trading Guidance for Buy/Sell Decisions - ' . NAMETITLE,
        //         'content'   => 'homepage/service/satoshi',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_satoshi',
        //         'flag'      => 'satoshi'
        //     ];
        // } else if ($service == "lux_btc_brokers") {
        //     $mdata = [
        //         'title'     => 'Lux BTC Brokers - ' . NAMETITLE,
        //         'content'   => 'homepage/service/lux_btc_brokers',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_luxbtc',
        //         'flag'      => 'luxbtc'
        //     ];
        // } else if ($service == "btc_elite_management") {
        //     $mdata = [
        //         'title'     => 'BTC Elite Management - ' . NAMETITLE,
        //         'content'   => 'homepage/service/btc_elite_management',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_btc_elite_management',
        //         'flag'      => 'btcelitemanagement'
        //     ];
        // } else {
        //     $mdata = [
        //         'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
        //         'content'   => 'homepage/service/finance',
        //         'extra'     => 'homepage/js/_js_index',
        //         'extragsap' => 'homepage/gsap/gsap_finance'
        //     ];
        // }

        if ($service == "satoshi_signal") {
            $mdata = [
                'title'     => 'Satoshi Signal - ' . NAMETITLE,
                'content'   => 'homepage/service/satoshi_signal',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_satoshi_signal',
                'flag'      => 'satoshisignal'
            ];
        } else if ($service == "lux_btc_brokers") {
            $mdata = [
                'title'     => 'Lux BTC Brokers - ' . NAMETITLE,
                'content'   => 'homepage/service/lux_btc_brokers',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_luxbtc',
                'flag'      => 'luxbtc'
            ];
        } else if ($service == "btc_elite_management") {
            $mdata = [
                'title'     => 'BTC Elite Management - ' . NAMETITLE,
                'content'   => 'homepage/service/btc_elite_management',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_btc_elite_management',
                'flag'      => 'btcelitemanagement'
            ];
        } else if ($service == "crypto_consulting") {
            $mdata = [
                'title'     => 'Crypto Consulting - ' . NAMETITLE,
                'content'   => 'homepage/service/crypto_consulting',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_crypto_consulting',
                'flag'      => 'cryptoconsulting'
            ];
        } else if ($service == "passive_income") {
            $mdata = [
                'title'     => 'Passive Income - ' . NAMETITLE,
                'content'   => 'homepage/service/passive_income',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_passive_income',
                'flag'      => 'passiveincome',
                'darkNav'   => true
            ];
        } else if ($service == "portfolio_creation") {
            $mdata = [
                'title'     => 'Portfolio Creation - ' . NAMETITLE,
                'content'   => 'homepage/service/portfolio_creation',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_portfolio_creation',
                'flag'      => 'portfolio'
            ];
        } else if ($service == "accumulation_plan") {
            $mdata = [
                'title'     => 'Accumulation Plan - ' . NAMETITLE,
                'content'   => 'homepage/service/accumulation_plan',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_accumulation_plan',
                'flag'      => 'accumulation',
                'darkNav'   => true
            ];
        } else if ($service == "funds_reallocation") {
            $mdata = [
                'title'     => 'Funds Reallocation - ' . NAMETITLE,
                'content'   => 'homepage/service/funds_reallocation',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_funds_reallocation',
                'flag'      => 'funds',
                'darkNav'   => true
            ];
        } else if ($service == "wealth_consulting") {
            $mdata = [
                'title'     => 'Wealth Consulting - ' . NAMETITLE,
                'content'   => 'homepage/service/wealth_consulting',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_wealth_consulting',
                'flag'      => 'wealth'
            ];
        } else if ($service == "tax_reduction") {
            $mdata = [
                'title'     => 'Tax Reduction - ' . NAMETITLE,
                'content'   => 'homepage/service/tax_reduction',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_tax_reduction',
                'flag'      => 'tax'
            ];
        } else if ($service == "capital_protection") {
            $mdata = [
                'title'     => 'Capital Protection - ' . NAMETITLE,
                'content'   => 'homepage/service/capital_protection',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_capital_protection',
                'flag'      => 'capital',
                'darkNav'   => true
            ];
        } else {
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index',
                'extragsap' => 'homepage/gsap/gsap_finance'
            ];
        }
        return view('homepage/layout/wrapper', $mdata);
    }

    public function signin()
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


    public function satoshi_price()
    {
        $mdata = [
            'title'     => 'Price - ' . NAMETITLE,
            'content'   => 'homepage/service/satoshi-price',
            'extra'     => 'homepage/service/js/_js_satoshi_price',
            'navoption' => true,
            'darkNav'   => true,
            'footer'    => false,
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function register_process()
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
            return redirect()->to(BASE_URL . 'homepage/satoshi_price#register')->withInput();
        }

        // Initial Data
        $mdata = [
            'email'         => htmlspecialchars($this->request->getVar('email')),
            'password'      => sha1(htmlspecialchars($this->request->getVar('pass'))),
            'timezone'      => htmlspecialchars($this->request->getVar('timezone')),
            'referral'      => htmlspecialchars($this->request->getVar('referral')),
            'role'          => htmlspecialchars($this->request->getVar('role')) ,
            'ip_address'    => htmlspecialchars($this->request->getIPAddress()),
        ];

        $tempUser = (object)[
            'email'  => htmlspecialchars($this->request->getVar('email')),
            'passwd' => sha1($this->request->getVar('pass'))
        ];
        session()->set('logged_user', $tempUser);


        $url = URLAPI . "/auth/register";
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        // Check if the result code is not 201
        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'homepage/satoshi_price#register')->withInput();
        } else {
            $subject = "Activation Account - BROKER LUX";
            sendmail_satoshi($mdata['email'], $subject,  emailtemplate_activation_account($result->message->otp, $mdata['email'],"BROKER LUX"),"BROKER LUX","brokerlux@pnglobalinternational.com");
            return redirect()->to(BASE_URL . 'auth/activate_member/' . base64_encode($mdata['email']));
        }
    }

    // public function satoshi_active_account($email)
    // {
    //     $email = base64_decode($email);

    //     // Call Endpoin Get Member By Email
    //     $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
    //     $result = satoshiAdmin($url)->result;

    //     if ($result->message->status == "active" && $result->message->membership == "expired") {
    //         return redirect()->to(BASE_URL . 'homepage/satoshi_register_payment/' . base64_encode($email));
    //     }

    //     $mdata = [
    //         'title'     => 'Active Account - ' . NAMETITLE,
    //         'content'   => 'homepage/service/satoshi-otp',
    //         'extra'     => 'homepage/service/js/_js_satoshi_otp',
    //         'navoption' => true,
    //         'emailuser' => $email
    //     ];

    //     return view('homepage/layout/wrapper', $mdata);
    // }

    // public function satoshi_check_otp()
    // {
    //     // Validation Field
    //     $rules = $this->validate([
    //         'first'     => [
    //             'label'     => 'First Column',
    //             'rules'     => 'required'
    //         ],
    //         'second'     => [
    //             'label'     => 'Second Column',
    //             'rules'     => 'required'
    //         ],
    //         'third'     => [
    //             'label'     => 'Third Column',
    //             'rules'     => 'required'
    //         ],
    //         'fourth'     => [
    //             'label'     => 'Fourth Column',
    //             'rules'     => 'required'
    //         ],
    //         'email'     => [
    //             'label'     => 'Email',
    //             'rules'     => 'required'
    //         ],
    //     ]);

    //     // Checking Validation
    //     if (!$rules) {
    //         echo json_encode(["code" => "500", "message" => $this->validation->listErrors()]);
    //         exit();
    //     }

    //     $first = htmlspecialchars($this->request->getVar('first'));
    //     $second = htmlspecialchars($this->request->getVar('second'));
    //     $third = htmlspecialchars($this->request->getVar('third'));
    //     $fourth = htmlspecialchars($this->request->getVar('fourth'));

    //     $mdata = [
    //         "otp"   => $first . $second . $third . $fourth,
    //         "email" => htmlspecialchars($this->request->getVar('email'))
    //     ];

    //     // Call Endpoin Activation Account
    //     $url = URLAPI . "/auth/activate?token=" . $mdata['otp'] . "&email=" . $mdata['email'];
    //     $result = satoshiAdmin($url, json_encode($mdata))->result;

    //     echo json_encode($result);
    // }

    public function set_capital_investment()
    {
        $mdata = [
            'title'     => 'Set Capital Investment - ' . NAMETITLE,
            'content'   => 'homepage/service/set_capital_investment',
            'extra'     => 'homepage/service/js/_js_set_capital_investment',
            // 'navoption' => true,
            // 'darkNav'   => true,
            'footer'    => false,
            'nav'       => false,
        ];

        return view('homepage/layout/wrapper', $mdata);
    }


    public function get_investment_config()
    {
        $url = URLAPI . "/v1/price";
        $result = satoshiAdmin($url)->result;

        $minCapital = (float) $result->message->price;
        $commission = (float) $result->message->commission;

        log_message('debug', 'API Price: ' . $minCapital . ', Commission: ' . $commission);

        $data = [
            'min_capital' => $minCapital,
            'additional_step' => 2000,
            'percentage_fee' => $commission,
            'membership_days' => 30
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
            'content'   => 'homepage/service/payment_option',
            'extra'     => 'homepage/service/js/_js_payment_option',
            // 'navoption' => true,
            // 'darkNav'   => true,
            'footer'    => false,
            'nav'       => false,
        ];

        return view('homepage/layout/wrapper', $mdata);
    }
    
    function createCoinPaymentTransaction($amount, $currency, $invoiceNumber,$buyer_email,$description)
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
            'buyer_email'=> $buyer_email,
            'item_name'  => $description,
            'key'        => $publicKey,
            'ipn_url'    => base_url().'hedgefund/auth/coinpayment_notify',
            'success_url'=> base_url().'homepage/payment_option',
            'cancel_url' => base_url()."hedgefund/auth/set_capital",
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
        log_message('error', "data cointpayment : ".json_encode($data));

        if ($data["status"] === "100") {
            $merchantOrderId = $data['invoice'] ?? null;
            $reference = $data['txn_id'] ?? null;
        
            // Callback tervalidasi
            $code = "pending";
            if ($data['status_text'] == 'Complete') {
                $code = "active";
            } elseif ($data['status_text'] == 'Failed') {
                $code = "failed";
            }
        
            $postData = array(
                "invoice"   => $merchantOrderId,
                "references"=> $reference,
                "status"    => $code
            );
            // Debugging sebelum kirim request

            log_message('error',"Sending data". json_encode($postData));
        
            $url = URLAPI . "/non/notify_payment";
            $response = satoshiAdmin($url, json_encode($postData));
            log_message('error',"Response: " . json_encode($response));
        }
    }

    public function returncrypto(){
        $this->session->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
        return redirect()->to(base_url().'homepage/payment_option'); 
    }

    public function usdt_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $netprice   = getExchange($payamount);
        $customerEmail = $_SESSION["logged_user"]->email;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
        ];

        $url        = URLAPI . "/non/paid_subscribe";
        $response   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $response->invoice;
        $description= "Monthly subscription LUX BTC Broker";

        $paymentResponse = $this->createCoinPaymentTransaction($netprice,'USDT.BEP20', $orderId,$customerEmail,$description);

        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'homepage/set_capital_investment'); 
        }
        
        return redirect()->to($paymentResponse['result']['checkout_url']); 
    }

    public function usdc_payment()
    {
        $payamount  = $_SESSION["payment_data"]["amount"];
        $netprice   = getExchange($payamount);
        $customerEmail = $_SESSION["logged_user"]->email;
        $postData = [
            'email' => $customerEmail,
            'amount' => $_SESSION["payment_data"]["totalcapital"],
        ];

        $url        = URLAPI . "/non/paid_subscribe";
        $response   = satoshiAdmin($url, json_encode($postData))->result->message;
        $orderId    = $response->invoice;
        $description= "Monthly subscription LUX BTC Broker";

        $paymentResponse = $this->createCoinPaymentTransaction($netprice,'USDC.BEP20', $orderId,$customerEmail,$description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'homepage/set_capital_investment'); 
        }
        
        return redirect()->to($paymentResponse['result']['checkout_url']); 
    }

    // public function card_payment()
    // {
    //     $session = session();
    //     $paymentdata = $session->get('payment_data');

    //     $mdata = [
    //         'title'     => 'Card Payment - ' . NAMETITLE,
    //         'content'   => 'homepage/service/card_payment',
    //         'extra'     => 'homepage/service/js/_js_card_payment',
    //         // 'navoption' => true,
    //         // 'darkNav'   => true,
    //         'footer'    => false,
    //         'nav'       => false,
    //         'payment_data' => $paymentdata,
    //     ];

    //     return view('homepage/layout/wrapper', $mdata);
    // }

    // public function confirm_crypto_payment()
    // {
    //     try {
    //         // Validasi request
    //         $rules = [
    //             'amount' => 'required',
    //         ];

    //         if (!$this->validate($rules)) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => $this->validator->getErrors()
    //             ])->setStatusCode(400);
    //         }

    //         $amount = $this->request->getPost('amount');

    //         // Jika amount berisi string "USDT" atau "usdt", hilangkan  
    //         $amount = str_replace(['USDT', 'usdt', 'USDC', 'usdc'], '', $amount);

    //         // Bersihkan nilai amount dari karakter non-numerik kecuali titik desimal
    //         $amount = preg_replace('/[^0-9.]/', '', $amount);

    //         // Konversi ke tipe data float
    //         $amount = (float) $amount;

    //         // Ambil email dari session
    //         $session = session();
    //         if (!$session->has('logged_user')) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'User tidak terautentikasi'
    //             ])->setStatusCode(401);
    //         }

    //         $email = $session->get('logged_user')->email;

    //         // Siapkan data untuk API
    //         $postData = [
    //             'email' => $email,
    //             'amount' => $amount
    //         ];

    //         $url = URLAPI . "/v1/subscribe/paid_subscribe";
    //         $response = satoshiAdmin($url, json_encode($postData));

    //         $result = $response->result;

    //         if (isset($result->code) && $result->code != 201) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => '<p>' . ($result->message ?? 'An error occurred on the API server') . '</p><p>Please try again or contact customer support.</p>'
    //             ])->setStatusCode(400);
    //         }

    //         // Hapus data pembayaran dari session
    //         $session->remove('payment_data');

    //         // Perbarui data pengguna dalam session dengan data terbaru dari API
    //         $userData = [
    //             'email' => $email,
    //             'password' => $session->get('logged_user')->passwd
    //         ];

    //         // Ambil data pengguna terbaru dari API
    //         $userUrl = URLAPI . "/auth/signin";
    //         $userResponse = satoshiAdmin($userUrl, json_encode($userData));
    //         $userResult = $userResponse->result;

    //         // Jika berhasil mendapatkan data pengguna terbaru, perbarui session
    //         if (isset($userResult->code) && $userResult->code == 200) {
    //             $session->set('logged_user', $userResult->message);
    //         }

    //         return $this->response->setJSON([
    //             'status' => 'success',
    //             'message' => '<p>Your payment is being processed and your account will be ready within 48 hours.</p><p>We will send you an email when your account is active.</p>',
    //             'data' => [
    //                 'email' => $email, // Gunakan email dari session jika tidak ada dalam respons
    //                 'amount' => $amount, // Gunakan amount dari request jika tidak ada dalam respons
    //             ]
    //         ]);

    //         // Tambahkan end_date jika ada dalam respons
    //         if (isset($result->end_date)) {
    //             $responseData['data']['end_date'] = $result->end_date;
    //         }

    //         // Perbarui dengan data dari respons jika tersedia
    //         if (isset($result->email)) {
    //             $responseData['data']['email'] = $result->email;
    //         }

    //         if (isset($result->amount)) {
    //             $responseData['data']['amount'] = $result->amount;
    //         }

    //         return $this->response->setJSON($responseData)->setStatusCode(201);
    //     } catch (\Exception $e) {
    //         log_message('error', 'Exception: ' . $e->getMessage());
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'An error occurred while processing the payment'
    //         ])->setStatusCode(500);
    //     }
    // }

    // public function confirm_card_payment()
    // {
    //     try {
    //         // Validasi request
    //         $rules = [
    //             'amount' => 'required',
    //             'payment_method_id' => 'required'
    //         ];

    //         if (!$this->validate($rules)) {
    //             session()->setFlashdata('failed', $this->validator->getErrors());
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => $this->validator->getErrors()
    //             ])->setStatusCode(400);
    //         }

    //         // Ambil data dari request
    //         $amount = $this->request->getPost('amount');
    //         $totalcapital = $_SESSION["payment_data"]["totalcapital"];
    //         $paymentMethodId = $this->request->getPost('payment_method_id');

    //         // Bersihkan nilai amount dari karakter non-numerik kecuali titik desimal
    //         $amount = preg_replace('/[^0-9.]/', '', $amount);

    //         // Konversi ke tipe data float
    //         $amount = (float) $amount;

    //         // Konversi ke sen untuk Stripe (Stripe menggunakan satuan sen)
    //         $amountInCents = $amount * 100;

    //         // Ambil email dari session
    //         $session = session();
    //         if (!$session->has('logged_user')) {
    //             session()->setFlashdata('failed', 'User not authenticated');
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'User not authenticated'
    //             ])->setStatusCode(401);
    //         }

    //         $loggedUser = $session->get('logged_user');
    //         $email = $loggedUser->email;

    //         // Inisialisasi Stripe
    //         \Stripe\Stripe::setApiKey(SECRET_KEY);

    //         try {
    //             // Buat payment intent di Stripe
    //             $paymentIntent = \Stripe\PaymentIntent::create([
    //                 'amount' => $amountInCents,
    //                 'currency' => 'eur',
    //                 'payment_method' => $paymentMethodId,
    //                 'automatic_payment_methods' => [
    //                     'enabled' => true,
    //                     'allow_redirects' => 'never', // Nonaktifkan metode pembayaran berbasis redirect
    //                 ],
    //             ]);

    //             if ($paymentIntent->status === 'requires_confirmation') {
    //                 $confirmedPaymentIntent = $paymentIntent->confirm();

    //                 // Jika pembayaran berhasil, simpan ke API
    //                 if ($confirmedPaymentIntent->status === 'succeeded') {
    //                     // Siapkan data untuk API
    //                     $postData = [
    //                         'email' => $email,
    //                         'amount' => $totalcapital,
    //                         'payment_method' => 'card',
    //                         'transaction_id' => $confirmedPaymentIntent->id
    //                     ];

    //                     $url = URLAPI . "/v1/subscribe/paid_subscribe";
    //                     $response = satoshiAdmin($url, json_encode($postData));

    //                     $result = $response->result;

    //                     // Periksa kode response dari API
    //                     if (isset($result->code) && $result->code != 201) {
    //                         // Jika API gagal, refund pembayaran
    //                         \Stripe\Refund::create([
    //                             'payment_intent' => $confirmedPaymentIntent->id
    //                         ]);

    //                         session()->setFlashdata('failed', $result->message ?? 'An error occurred on the API server. Please try again or contact customer support.');
    //                         return $this->response->setJSON([
    //                             'status' => 'error',
    //                             'message' => $result->message ?? 'An error occurred on the API server. Please try again or contact customer support.'
    //                         ])->setStatusCode(400);
    //                     }

    //                     // Hapus data pembayaran dari session
    //                     $session->remove('payment_data');

    //                     // Perbarui data pengguna dalam session dengan data terbaru dari API
    //                     $userData = [
    //                         'email' => $email,
    //                         'password' => $loggedUser->passwd
    //                     ];

    //                     // Ambil data pengguna terbaru dari API
    //                     $userUrl = URLAPI . "/auth/signin";
    //                     $userResponse = satoshiAdmin($userUrl, json_encode($userData));
    //                     $userResult = $userResponse->result;

    //                     // Jika berhasil mendapatkan data pengguna terbaru, perbarui session
    //                     if (isset($userResult->code) && $userResult->code == 200) {
    //                         $session->set('logged_user', $userResult->message);
    //                     }

    //                     // Set flash data untuk sukses
    //                     session()->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
    //                     return $this->response->setJSON([
    //                         'status' => 'success',
    //                         'message' => 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.'
    //                     ])->setStatusCode(200);
    //                 } else {
    //                     session()->setFlashdata('failed', 'Payment failed: ' . $confirmedPaymentIntent->status);
    //                     return $this->response->setJSON([
    //                         'status' => 'error',
    //                         'message' => 'Payment failed: ' . $confirmedPaymentIntent->status
    //                     ])->setStatusCode(400);
    //                 }
    //             } else {
    //                 session()->setFlashdata('failed', 'Payment failed: ' . $paymentIntent->status);
    //                 return $this->response->setJSON([
    //                     'status' => 'error',
    //                     'message' => 'Payment failed: ' . $paymentIntent->status
    //                 ])->setStatusCode(400);
    //             }
    //         } catch (\Stripe\Exception\CardException $e) {
    //             // Kartu ditolak
    //             session()->setFlashdata('failed', 'Card declined: ' . $e->getError()->message);
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Card declined: ' . $e->getError()->message
    //             ])->setStatusCode(400);
    //         } catch (\Stripe\Exception\RateLimitException $e) {
    //             // Terlalu banyak request
    //             session()->setFlashdata('failed', 'Too many requests to Stripe. Please try again later.');
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Too many requests to Stripe. Please try again later.'
    //             ])->setStatusCode(400);
    //         } catch (\Stripe\Exception\InvalidRequestException $e) {
    //             // Parameter tidak valid
    //             session()->setFlashdata('failed', 'Invalid parameters: ' . $e->getError()->message);
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Invalid parameters: ' . $e->getError()->message
    //             ])->setStatusCode(400);
    //         } catch (\Stripe\Exception\AuthenticationException $e) {
    //             // Autentikasi gagal
    //             session()->setFlashdata('failed', 'Stripe authentication failed. Please contact administrator.');
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Stripe authentication failed. Please contact administrator.'
    //             ])->setStatusCode(400);
    //         } catch (\Stripe\Exception\ApiConnectionException $e) {
    //             // Koneksi ke Stripe gagal
    //             session()->setFlashdata('failed', 'Connection to Stripe failed. Please try again later.');
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Connection to Stripe failed. Please try again later.'
    //             ])->setStatusCode(400);
    //         } catch (\Stripe\Exception\ApiErrorException $e) {
    //             // Error API Stripe lainnya
    //             session()->setFlashdata('failed', 'Stripe error: ' . $e->getError()->message);
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Stripe error: ' . $e->getError()->message
    //             ])->setStatusCode(400);
    //         }
    //     } catch (\Exception $e) {
    //         log_message('error', 'Exception: ' . $e->getMessage());
    //         session()->setFlashdata('failed', 'An internal error occurred: ' . $e->getMessage());
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'An internal error occurred: ' . $e->getMessage()
    //         ])->setStatusCode(500);
    //     }
    // }

    // public function satoshi_register_payment($email)
    // {
    //     $email = base64_decode($email);
    //     // Call Endpoin Get Member By Email
    //     $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
    //     $result = satoshiAdmin($url)->result->message;

    //     $price = [
    //         "1m"    => 250,
    //         "3m"    => 600,
    //         "6m"    => 1050,
    //         "1y"    => 1800
    //     ];

    //     $selisihReferral = [
    //         "1m"    => 25,
    //         "3m"    => 75,
    //         "6m"    => 150,
    //         "1y"    => 300
    //     ];

    //     $mdata = [
    //         'title'     => 'Active Account - ' . NAMETITLE,
    //         'content'   => 'homepage/service/satoshi-payment',
    //         'extra'     => 'homepage/service/js/_js_satoshi_payment',
    //         'navoption' => true,
    //         'member'    => $result,
    //         'price'     => $price,
    //         'disc'      => $selisihReferral
    //     ];

    //     return view('homepage/layout/wrapper', $mdata);
    // }

    // public function satoshi_register_process($email)
    // {
    //     $email = base64_decode($email);
    //     // Call Endpoin Get Member By Email
    //     $url = URLAPI . "/auth/getmember_byemail?email=" . $email;
    //     $result = satoshiAdmin($url)->result->message;

    //     // Stripe secret key
    //     \Stripe\Stripe::setApiKey(SECRET_KEY);
    //     $paymentMethodId = $_POST['payment_method_id'];

    //     $getprice = htmlspecialchars($this->request->getVar('price'));
    //     $currency = 'eur';
    //     $mdata = [
    //         "email" => $result->email,
    //         "referral"  => $result->id_referral
    //     ];

    //     if (!empty($result->id_referral)) {
    //         $discount = [
    //             "1m"    => 25,
    //             "3m"    => 75,
    //             "6m"    => 150,
    //             "1y"    => 300
    //         ];
    //     } else {
    //         $discount = [
    //             "1m"    => 0,
    //             "3m"    => 0,
    //             "6m"    => 0,
    //             "1y"    => 0
    //         ];
    //     }



    //     if ($getprice == 250) {
    //         $mdata['amount'] = $getprice - $discount['1m'];
    //         $mdata['period'] = 30;
    //     } else if ($getprice == 600) {
    //         $mdata['amount'] = $getprice - $discount['3m'];
    //         $mdata['period'] = 30 * 3;
    //     } else if ($getprice == 1050) {
    //         $mdata['amount'] = $getprice - $discount['6m'];
    //         $mdata['period'] = 30 * 6;
    //     } else if ($getprice == 1800) {
    //         $mdata['amount'] = $getprice - $discount['1y'];
    //         $mdata['period'] = 365;
    //     } else {
    //         session()->setFlashdata('failed', "Invalid Amount, Please Try Again");
    //         return redirect()->to(BASE_URL . 'homepage/satoshi_register_payment/' .  base64_encode($result->email));
    //     }


    //     try {

    //         $paymentIntent = \Stripe\PaymentIntent::create([
    //             'amount' => $mdata['amount'],
    //             'currency' => $currency,
    //             'payment_method' => $paymentMethodId,
    //             'automatic_payment_methods' => [
    //                 'enabled' => true,
    //                 'allow_redirects' => 'never', // Disable redirect-based payment methods
    //             ],
    //         ]);

    //         if ($paymentIntent->status === 'requires_confirmation') {
    //             $confirmedPaymentIntent = $paymentIntent->confirm();

    //             // If the payment was successful, proceed with creating the calendar event
    //             if ($confirmedPaymentIntent->status === 'succeeded') {
    //                 // POST subscribe member
    //                 $url = URLAPI . "/v1/subscription/paidsubscribe";
    //                 $result = satoshiAdmin($url, json_encode($mdata))->result->message;

    //                 // Perbarui data pengguna dalam session jika pengguna sudah login
    //                 $session = session();
    //                 if ($session->has('logged_user')) {
    //                     $loggedUser = $session->get('logged_user');
    //                     $userData = [
    //                         'email' => $loggedUser->email,
    //                         'password' => $loggedUser->passwd
    //                     ];

    //                     // Ambil data pengguna terbaru dari API
    //                     $userUrl = URLAPI . "/auth/signin";
    //                     $userResponse = satoshiAdmin($userUrl, json_encode($userData));
    //                     $userResult = $userResponse->result;

    //                     // Jika berhasil mendapatkan data pengguna terbaru, perbarui session
    //                     if (isset($userResult->code) && $userResult->code == 200) {
    //                         $session->set('logged_user', $userResult->message);
    //                     }
    //                 }

    //                 session()->setFlashdata('successPayment', 'Thank you for your register, wait 1-5 minutes our team will be contact');
    //                 header("Location: " . BASE_URL . "homepage/service?service=" . base64_encode("satoshi_signal"));
    //                 exit();
    //             }
    //         }
    //     } catch (\Stripe\Exception\CardException $e) {
    //         session()->setFlashdata('failed', 'Payment Failed: ' . $e->getError()->message);
    //         header("Location: " . BASE_URL . 'homepage/satoshi_register_payment/' .  base64_encode($result->email));
    //         exit();
    //     }
    // }

    public function contact_success()
    {
        $mdata = [
            'title'     => 'Contact Success - ' . NAMETITLE,
            'content'   => 'homepage/contact/contact_success',
            'darkNav'   => true
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    // Contact Booking Consultant
    public function bookingconsultation()
    {
        // Check if service parameter exists, if not set default value
        $service = isset($_GET['service']) ? base64_decode($_GET['service']) : 'general-consultation';
        $service = explode('-', $service);
        $subject = $service[0];

        $mdata = [
            'title'     => 'Booking Consultant - ' . NAMETITLE,
            'content'   => 'homepage/contact/bookingconsultation',
            'extra'     => 'homepage/contact/js/_js_bookingconsultation',
            'subject'   => $subject,
            'darkNav'   => true
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }


    public function getSlots()
    {
        // $calendarId = 'pnglobal.usa@gmail.com';
        $calendarId = 'primary';
        $userTimeZone = $this->request->getPost('timezone');

        $availableSlots = $this->googleCalendarService->getSlotsNextDay($calendarId, $userTimeZone);

        $mdata = [
            "slot"  => $availableSlots,
            "timezone"  => $userTimeZone
        ];
        echo json_encode($mdata);
        die;
    }

    public function booking_summary()
    {
        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'trim|required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'trim|required'
            ],
            'email.*'   => [
                'label'     => 'Email',
                'rules'     => 'trim|valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'trim|required'
            ],
            'desc'      => [
                'label'     => 'Description',
                'rules'     => 'trim|required'
            ],
            'timezone'      => [
                'label'     => 'Timezone',
                'rules'     => 'trim|required'
            ],
            'schedule'      => [
                'label'     => 'Schedule',
                'rules'     => 'trim|required'
            ],
            'subject'      => [
                'label'     => 'Subject',
                'rules'     => 'required'
            ],
        ]);

        // Get original service parameter if exists
        $original_service = $this->request->getVar('original_service');
        $redirect_url = BASE_URL . 'homepage/bookingconsultation';
        if (!empty($original_service)) {
            $redirect_url .= '?service=' . $original_service;
        }

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to($redirect_url)->withInput();
        }

        // Filter EMAIL
        $email = $this->request->getVar('email');
        $newEmail = array();
        foreach ($email as $dt) {
            array_push($newEmail, filter_var($dt, FILTER_VALIDATE_EMAIL));
        }

        /* Temporarily disabled referral process
        $tempreferral = trim(htmlspecialchars($this->request->getVar('referral')));
        $_SESSION["referral"] = null;
        $referral = null;
        if (!empty($tempreferral)) {
            // Call API
            $url = URLAPI . "/v1/member/get_byreferral?refcode=" . $tempreferral;
            $resultReff = satoshiAdmin($url)->result;

            $referral = ($resultReff->code == 200) ? $tempreferral : null;
            $_SESSION["referral"] = ($resultReff->code == 200) ? $resultReff->message->id : null;
        }
        */

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'datetime'      => htmlspecialchars($this->request->getVar('schedule')),
            'timezone'      =>  htmlspecialchars($this->request->getVar('timezone')),
            'description'   => htmlspecialchars($this->request->getVar('desc')),
            'email'         => $newEmail,
            'subject'       => htmlspecialchars($this->request->getVar('subject')),
            'referral'      => null // Temporarily disabled referral
        ];

        $this->session->set('client', $mdata);

        $views = [
            'title'     => 'Summary - ' . NAMETITLE,
            'content'   => 'homepage/contact/summary_booking',
            'extra'     => 'homepage/contact/js/_js_summary_booking',
            'data'      => $mdata
        ];

        return view('homepage/layout/wrapper-contactus', $views);
    }

    public function booking_proccess()
    {
        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY);
        $paymentMethodId = $_POST['payment_method_id'];

        /* Temporarily disabled referral amount check
        if (!empty($_SESSION["referral"])) {
            $amount = 25000; // Replace with the actual amount in cents (e.g., $50.00 = 5000)
        } else {
            $amount = 35000;
        }
        */

        // Set fixed amount while referral is disabled
        $amount = 35000;

        $currency = 'eur'; // Replace with your desired currency

        try {
            // Create a PaymentIntent with the payment method ID
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method' => $paymentMethodId,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // Disable redirect-based payment methods
                ],
            ]);

            if ($paymentIntent->status === 'requires_confirmation') {
                $confirmedPaymentIntent = $paymentIntent->confirm();

                // If the payment was successful, proceed with creating the calendar event
                if ($confirmedPaymentIntent->status === 'succeeded') {
                    // Call API
                    $mdata = array(
                        "email"     => $_SESSION['client']['email'][0],
                        "amount"    => $amount / 100,
                        "referral"  => null // Temporarily disabled referral
                    );

                    // Call API to record booking
                    $url = URLAPI . "/auth/bookconsultation";
                    $resultReff = satoshiAdmin($url, json_encode($mdata))->result;

                    // Create Google Calendar
                    $calendarId = 'primary'; // Your calendar ID
                    $slot = explode("#", $_SESSION['client']['datetime']);
                    $slotStart = $slot[0];
                    $slotEnd = $slot[1];

                    $eventName = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];
                    $timezone = $_SESSION['client']['timezone'];
                    $description = '<div>
                                        <p>Fullname: ' . $_SESSION['client']['fname']  . ' ' . $_SESSION['client']['lname'] . '</p>
                                        <p>Whatsapp: ' . $_SESSION['client']['whatsapp'] . '</p>
                                        <p>Email: ' . $_SESSION['client']['email'][0] . '</p>
                                        <p>' . $_SESSION['client']['description'] . '</p>
                                    </div>';

                    // Parse and format slot times back to RFC3339 for event creation
                    $slotStartDT = DateTime::createFromFormat('d-m-Y H:i:s', $slotStart, new DateTimeZone($timezone));
                    $slotEndDT = DateTime::createFromFormat('d-m-Y H:i:s', $slotEnd, new DateTimeZone($timezone));

                    $eventData = [
                        'summary' => $eventName,
                        'description' => $description,
                        'start' => [
                            'dateTime' => $slotStartDT->format(DateTime::RFC3339),
                            'timeZone' => $timezone,
                        ],
                        'end' => [
                            'dateTime' => $slotEndDT->format(DateTime::RFC3339),
                            'timeZone' => $timezone,
                        ],
                    ];

                    try {
                        $this->googleCalendarService->createEvent($calendarId, $eventData);

                        // Subject
                        $subject = NAMETITLE . ' - Booking Consultation ' . $_SESSION['client']['subject'] . ' | ' . $_SESSION['client']['fname'];

                        // Assign SESSION client
                        $mdata = $_SESSION['client'];
                        sendmail_booking($subject, $mdata);
                    } catch (\RuntimeException $e) {
                        session()->setFlashdata('failed', 'Failed to booking schedule: ' . $e->getMessage());
                        header("Location: " . BASE_URL . 'homepage/bookingconsultation');
                        exit();
                    }
                }
            }
        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: ' . $e->getError()->message);
            header("Location: " . BASE_URL . 'homepage/bookingconsultation');
            exit();
        }
    }

    // Contact Form Normaly
    public function contactform()
    {
        $service = base64_decode($_GET['service']);
        $service = explode('-', $service);
        $subject = $service[0];

        $mdata = [
            'title'     => 'Contact Form - ' . NAMETITLE,
            'content'   => 'homepage/contact/contactform',
            'extra'     => 'homepage/contact/js/_js_contactform',
            'subject'   => $subject,
            'darkNav'   => true
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function contactform_proccess()
    {
        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'required'
            ],
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'required'
            ],
            'desc'      => [
                'label'     => 'Description',
                'rules'     => 'required'
            ],
            'subject'      => [
                'label'     => 'Subject',
                'rules'     => 'required'
            ],

        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/contactform')->withInput();
        }

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'description'   => htmlspecialchars($this->request->getVar('desc')),
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL)
        ];

        $tempSubject = htmlspecialchars($this->request->getVar('subject'));

        // Subject
        $subject = NAMETITLE . ' - Contact Form ' . $tempSubject . ' | ' . $mdata['fname'];

        sendmail_contactform($subject, $mdata);
    }

    // Contact Form for Get Referral
    public function contactreferral()
    {
        $mdata = [
            'title'     => 'Contact Form Referral- ' . NAMETITLE,
            'content'   => 'homepage/contact/contactreferral',
            'extra'     => 'homepage/contact/js/_js_contactreferral',
            'darkNav'   => true
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function contactreferral_proccess()
    {
        // Validation Field
        $rules = $this->validate([
            'fname'     => [
                'label'     => 'Name',
                'rules'     => 'required'
            ],
            'lname'     => [
                'label'     => 'Last Name',
                'rules'     => 'required'
            ],
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'whatsapp'  => [
                'label'     => 'Whatsapp',
                'rules'     => 'required'
            ],
            'mtongue'  => [
                'label'     => 'Mother Tongoue',
                'rules'     => 'required'
            ],
            'language'  => [
                'label'     => 'Language',
                'rules'     => 'required'
            ],
            'country'  => [
                'label'     => 'Country',
                'rules'     => 'required'
            ],
            'identity'      => [
                'label'     => 'Identity',
                'rules'     => 'uploaded[identity]|max_size[identity,20000]|mime_in[identity,application/pdf]'
            ],

        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/contactreferral')->withInput();
        }

        // Get File PDF
        $filePDF = $this->request->getFile('identity');
        $filePath = $filePDF->getTempName();
        $fileName = $filePDF->getClientName();

        // Initial Data
        $mdata = [
            'fname'         => htmlspecialchars($this->request->getVar('fname')),
            'lname'         => htmlspecialchars($this->request->getVar('lname')),
            'whatsapp'      => htmlspecialchars($this->request->getVar('whatsapp')),
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL),
            'instagram'     => htmlspecialchars($this->request->getVar('instagram')),
            'tiktok'        => htmlspecialchars($this->request->getVar('tiktok')),
            'fprofile'      => htmlspecialchars($this->request->getVar('fprofile')),
            'fgroup'        => htmlspecialchars($this->request->getVar('fgroup')),
            'fpage'         => htmlspecialchars($this->request->getVar('fpage')),
            'linkedin'      => htmlspecialchars($this->request->getVar('linkedin')),
            'discord'       => htmlspecialchars($this->request->getVar('discord')),
        ];

        // Subject
        $subject = NAMETITLE . ' - Request Referral ' . $mdata['fname'];

        sendmail_referral($subject, $mdata, $filePath, $fileName);
    }

    public function connection()
    {
        $mdata = [
            'title'     => 'Connections - ' . NAMETITLE,
            'content'   => 'homepage/connection',
            'extra'     => 'homepage/js/_js_index',
            'extragsap' => 'homepage/gsap/gsap_finance'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function privacy_policy()
    {
        $mdata = [
            'title'     => 'Privacy Policy - ' . NAMETITLE,
            'content'   => 'homepage/privacy_policy',
            'extra'     => 'homepage/js/_js_privacy_policy',
            'flag'      => 'privacy'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function terms_conditions()
    {
        $mdata = [
            'title'     => 'Privacy Policy - ' . NAMETITLE,
            'content'   => 'homepage/terms_conditions',
            'extra'     => 'homepage/js/_js_privacy_policy',
            'flag'      => 'terms'
        ];

        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function tutorial()
    {
        $mdata = [
            'title'     => 'Tutorial - ' . NAMETITLE,
            'content'   => 'homepage/binance/tutorial',
            'extra'     => 'homepage/binance/js/_js_tutorial',
            'footer'    => false,
            'nav'       => false
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function register_api()
    {
        $mdata = [
            'title'     => 'Register API - ' . NAMETITLE,
            'content'   => 'homepage/binance/api',
            'extra'     => 'homepage/binance/js/_js_api',
            'footer'    => false,
            'nav'       => false
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function save_binance_api()
    {
        $rules = $this->validate([
            'api_key' => [
                'label'     => 'API Key',
                'rules'     => 'required'
            ],
            'api_secret' => [
                'label'     => 'API Secret',
                'rules'     => 'required'
            ],
        ]);

        if (!$rules) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $this->validation->listErrors()
            ]);
        }

        // Menggunakan session() helper untuk mengakses session
        $session = session();

        // Periksa apakah logged_user adalah object atau array
        if (isset($session->logged_user)) {
            if (is_object($session->logged_user)) {
                $email = $session->logged_user->email;
                $pass = $session->logged_user->passwd;
            } else {
                $email = $session->logged_user['email'];
                $pass = $session->logged_user['passwd'];
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User session not found. Please login again.'
            ]);
        }

        $userData = [
            'email' => $email,
            'password' => $pass
        ];

        $url = URLAPI . "/auth/signin";
        $response = satoshiAdmin($url, json_encode($userData));

        // Berdasarkan struktur respons yang diberikan
        if (isset($response->result) && isset($response->result->message) && isset($response->result->message->id)) {
            $id = $response->result->message->id;
            $api_key = $this->request->getVar('api_key');
            $api_secret = $this->request->getVar('api_secret');

            $mdata = [
                'id_member' => $id,
                'api_key' => $api_key,
                'api_secret' => $api_secret
            ];

            $url = URLAPI . "/v1/member/set_api";
            $apiResponse = satoshiAdmin($url, json_encode($mdata));

            if (isset($apiResponse->result) && $apiResponse->result) {
                $session->setFlashdata('success', 'API Key and Secret saved successfully');
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'API Key and Secret saved successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save API Key and Secret'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Authentication failed or invalid response format'
            ]);
        }
    }

    public function account_deletion()
    {
        $step = base64_decode(@$_GET['step']);

        if ($step == 'second_step' || $step == 'third_step') {
            $mdata = [
                'title'     => 'Account Deletion - ' . NAMETITLE,
                'content'   => 'homepage/account_deletion',
                'extra'     => 'homepage/js/_js_account_deletion',
                'step'      => $step
            ];
        } else {
            $mdata = [
                'title'     => 'Account Deletion - ' . NAMETITLE,
                'content'   => 'homepage/account_deletion',
                'extra'     => 'homepage/js/_js_account_deletion',
                'step'      => 'first_step'
            ];
        }


        return view('homepage/layout/wrapper-contactus', $mdata);
    }

    public function account_deletion_proccess()
    {

        // Validation Field
        $rules = $this->validate([
            'email'   => [
                'label'     => 'Email',
                'rules'     => 'valid_email'
            ],
            'reason'      => [
                'label'     => 'Reason',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'homepage/account_deletion?step=' . base64_encode('second_step'))->withInput();
        }

        // Initial Data
        $mdata = [
            'email'         => filter_var($this->request->getVar('email'), FILTER_VALIDATE_EMAIL),
            'reason'        => htmlspecialchars($this->request->getVar('reason')),
        ];

        // Subject
        $subject = NAMETITLE . ' - Account Deletion ' . $mdata['email'];
        sendmail_accountdel($subject, $mdata);
    }

    public function training_course()
    {
        $mdata = [
            'title'     => 'Training Courses - ' . NAMETITLE,
            'content'   => 'homepage/training_course',
            'extra'     => 'homepage/js/_js_training_course',
            'extragsap' => 'homepage/gsap/gsap_training_course',
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function subscribe_newsletter()
    {
        try {
            // Validasi email
            $rules = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email'
                ]
            ]);

            if (!$rules) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $this->validation->listErrors()
                ]);
            }

            $email = $this->request->getPost('email');

            // Panggil API untuk menambahkan email ke newsletter
            $url = URLAPI . "/newsletter/add?email=" . $email;
            $response = satoshiAdmin($url);

            if (isset($response->result) && $response->result->code == 201) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Successfully subscribed to newsletter'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => isset($response->result->message) ? $response->result->message : 'Failed to subscribe to newsletter'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Newsletter subscription error: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred while processing your request'
            ]);
        }
    }
}
