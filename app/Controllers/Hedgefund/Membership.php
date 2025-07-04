<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;

class Membership extends BaseController
{
    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya member yang boleh mengakses halaman ini
        if (!in_array($loggedUser->role, ['member', 'referral'])) {
            exit();
        }
    }

    public function index()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');
        $refcode = $loggedUser->refcode;

        $mdata = [
            'title'     => 'Membership - ' . NAMETITLE,
            'content'   => 'member/membership/index',
            'extra'     => 'member/membership/js/_js_index',
            'active_membership' => 'active',
            'refcode' => $refcode,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function set_investment_capital()
    {
        $mdata = [
            'title'     => 'Set Investment Capital - ' . NAMETITLE,
            'content'   => 'member/membership/set_investment_capital',
            'extra'     => 'member/membership/js/_js_set_investment_capital',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    /**
     * API untuk mendapatkan data investment capital
     * 
     * @return \CodeIgniter\HTTP\Response
     */


    /**
     * API untuk menerima data konfirmasi pembayaran
     * 
     * Email diambil dari session logged_user dan dikirimkan ke API
     * bersama dengan amount (nilai pembayaran)
     * 
     * @return \CodeIgniter\HTTP\Response
     */
    public function confirm_crypto_payment()
    {
        try {
            // Validasi request
            $rules = [
                'amount' => 'required',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $this->validator->getErrors()
                ])->setStatusCode(400);
            }

            // Ambil data dari request
            $amount = $this->request->getPost('amount');

            // Jika amount berisi string "USDT" atau "usdt", hilangkan
            $amount = str_replace(['USDT', 'usdt', 'USDC', 'usdc'], '', $amount);

            // Bersihkan nilai amount dari karakter non-numerik kecuali titik desimal
            $amount = preg_replace('/[^0-9.]/', '', $amount);

            // Konversi ke tipe data float
            $amount = (float) $amount;

            // Ambil email dari session
            $session = session();
            if (!$session->has('logged_user')) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User tidak terautentikasi'
                ])->setStatusCode(401);
            }

            $loggedUser = $session->get('logged_user');
            $email = $loggedUser->email;

            // Siapkan data untuk API
            $postData = [
                'email' => $email,
                'amount' => $amount
            ];

            $url = URLAPI . "/v1/subscribe/paid_subscribe";
            $response = satoshiAdmin($url, json_encode($postData));

            $result = $response->result;

            // Periksa kode response dari API
            if (isset($result->code) && $result->code != 201) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => '<p>' . ($result->message ?? 'An error occurred on the API server') . '</p><p>Please try again or contact customer support.</p>'
                ])->setStatusCode(400);
            }

            // Pastikan properti yang diperlukan ada dalam respons
            $responseData = [
                'status' => 'success',
                'message' => '<p>Your payment is being processed and your account will be ready within 48 hours.</p><p>We will send you an email when your account is active.</p>',
                'data' => [
                    'email' => $email, // Gunakan email dari session jika tidak ada dalam respons
                    'amount' => $amount, // Gunakan amount dari request jika tidak ada dalam respons
                ]
            ];

            // Tambahkan end_date jika ada dalam respons
            if (isset($result->end_date)) {
                $responseData['data']['end_date'] = $result->end_date;
            }

            // Perbarui dengan data dari respons jika tersedia
            if (isset($result->email)) {
                $responseData['data']['email'] = $result->email;
            }

            if (isset($result->amount)) {
                $responseData['data']['amount'] = $result->amount;
            }

            // Perbarui data pengguna dalam session dengan data terbaru dari API
            $userData = [
                'email' => $email,
                'password' => $loggedUser->passwd
            ];

            // Ambil data pengguna terbaru dari API
            $userUrl = URLAPI . "/auth/signin";
            $userResponse = satoshiAdmin($userUrl, json_encode($userData));
            $userResult = $userResponse->result;

            // Jika berhasil mendapatkan data pengguna terbaru, perbarui session
            if (isset($userResult->code) && $userResult->code == 200) {
                $session->set('logged_user', $userResult->message);
            }

            return $this->response->setJSON($responseData)->setStatusCode(201);
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
        $session = session();

        // Periksa apakah ada data pembayaran dalam session
        if (!$session->has('payment_data')) {
            return redirect()->to('/member/membership/set_investment_capital');
        }

        $paymentData = $session->get('payment_data');

        $mdata = [
            'title'     => 'Payment Option - ' . NAMETITLE,
            'content'   => 'member/membership/payment_option',
            'extra'     => 'member/membership/js/_js_payment_option',
            'active_membership' => 'active',
            'payment_data' => $paymentData,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
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

        $paymentResponse = $this->createCoinPaymentTransaction(10,COINPAYMENTS_CURRENCY_USDT, $orderId,$customerEmail,$description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'member/membership/set_investment_capital'); 
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

        $paymentResponse = $this->createCoinPaymentTransaction($netprice,COINPAYMENTS_CURRENCY_USDC, $orderId,$customerEmail,$description);
        if ($paymentResponse['error'] !== 'ok') {
            $this->session->setFlashdata('error', 'There was a problem processing your purchase please try again');
            return redirect()->to(base_url().'homepage/set_capital_investment'); 
        }
        
        return redirect()->to($paymentResponse['result']['checkout_url']); 
    }
    
    // public function card_payment()
    // {
    //     $session = session();

    //     // Periksa apakah ada data pembayaran dalam session
    //     if (!$session->has('payment_data')) {
    //         return redirect()->to('/member/membership/set_investment_capital');
    //     }

    //     $paymentData = $session->get('payment_data');

    //     $mdata = [
    //         'title'     => 'Card Payment - ' . NAMETITLE,
    //         'content'   => 'member/membership/card_payment',
    //         'extra'     => 'member/membership/js/_js_card_payment',
    //         'active_membership' => 'active',
    //         'payment_data' => $paymentData,
    //     ];

    //     return view('member/layout/dashboard_wrapper', $mdata);
    // }

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
                'ipn_url'    => base_url().'homepage/coinpayment_notify',
                'success_url'=> base_url().'member/membership/returncrypto',
                'cancel_url' => base_url()."member/membership/set_capital_investment",
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


    public function returncrypto()
    {
        $session = session();

        if (!$session->has('logged_user')) {
            return redirect()->to('/member/auth/login');
        }
        $this->session->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
        return redirect()->to(base_url().'member/membership/payment_option'); 

    }

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
    //                 'message' => implode(', ', $this->validator->getErrors())
    //             ])->setStatusCode(400);
    //         }

    //         // Ambil data dari request
    //         $amount = $this->request->getPost('amount');
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
    //                         'amount' => $amount,
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
    //                     log_message('debug', 'Payment successful, returning JSON response');
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

    public function api()
    {
        $mdata = [
            'title'     => 'API - ' . NAMETITLE,
            'content'   => 'member/membership/api',
            'extra'     => 'member/membership/js/_js_api',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
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

            $userUrl = URLAPI . "/auth/signin";
            $userResponse = satoshiAdmin($userUrl, json_encode($userData));
            $userResult = $userResponse->result;

            // Jika berhasil mendapatkan data pengguna terbaru, perbarui session
            if (isset($userResult->code) && $userResult->code == 200) {
                $session->set('logged_user', $userResult->message);
            }

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
}
