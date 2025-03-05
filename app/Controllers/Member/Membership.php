<?php

namespace App\Controllers\Member;

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
        if ($loggedUser->role !== 'member') {
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
    public function get_investment_config()
    {
        $url = URLAPI . "/v1/price";
        $result = satoshiAdmin($url)->result;

        // Pastikan data dari API dikonversi ke tipe data yang benar
        $minCapital = (float) $result->message->price;
        $commission = (float) $result->message->commission;

        // Debug untuk melihat nilai yang diterima dari API
        log_message('debug', 'API Price: ' . $minCapital . ', Commission: ' . $commission);

        $data = [
            'min_capital' => $minCapital,
            'additional_step' => 2000,
            'percentage_multiplier' => $commission, // Nilai dari API
            'percentage_fee' => 0.11, // 11% untuk membership fee
            'euro_conversion_rate' => 0.844, // Kurs USD ke Euro
            'membership_days' => 30
        ];

        return $this->response->setJSON($data);
    }

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

    /**
     * Menyimpan data pembayaran ke dalam session
     */
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

    public function usdt_payment()
    {
        $session = session();

        // Periksa apakah ada data pembayaran dalam session
        if (!$session->has('payment_data')) {
            return redirect()->to('/member/membership/set_investment_capital');
        }

        $paymentData = $session->get('payment_data');

        $mdata = [
            'title'     => 'USDT Payment - ' . NAMETITLE,
            'content'   => 'member/membership/usdt_payment',
            'extra'     => 'member/membership/js/_js_usdt_payment',
            'active_membership' => 'active',
            'payment_data' => $paymentData,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdc_payment()
    {
        $session = session();

        // Periksa apakah ada data pembayaran dalam session
        if (!$session->has('payment_data')) {
            return redirect()->to('/member/membership/set_investment_capital');
        }

        $paymentData = $session->get('payment_data');
        $mdata = [
            'title'     => 'USDC Payment - ' . NAMETITLE,
            'content'   => 'member/membership/usdc_payment',
            'extra'     => 'member/membership/js/_js_usdc_payment',
            'active_membership' => 'active',
            'payment_data' => $paymentData,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function card_payment()
    {
        $session = session();

        // Periksa apakah ada data pembayaran dalam session
        if (!$session->has('payment_data')) {
            return redirect()->to('/member/membership/set_investment_capital');
        }

        $paymentData = $session->get('payment_data');

        $mdata = [
            'title'     => 'Card Payment - ' . NAMETITLE,
            'content'   => 'member/membership/card_payment',
            'extra'     => 'member/membership/js/_js_card_payment',
            'active_membership' => 'active',
            'payment_data' => $paymentData,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function confirm_card_payment()
    {
        try {
            // Validasi request
            $rules = [
                'amount' => 'required',
                'payment_method_id' => 'required'
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('failed', $this->validator->getErrors());
                return redirect()->to('/member/membership/card_payment');
            }

            // Ambil data dari request
            $amount = $this->request->getPost('amount');
            $paymentMethodId = $this->request->getPost('payment_method_id');

            // Bersihkan nilai amount dari karakter non-numerik kecuali titik desimal
            $amount = preg_replace('/[^0-9.]/', '', $amount);

            // Konversi ke tipe data float
            $amount = (float) $amount;

            // Konversi ke sen untuk Stripe (Stripe menggunakan satuan sen)
            $amountInCents = $amount * 100;

            // Ambil email dari session
            $session = session();
            if (!$session->has('logged_user')) {
                session()->setFlashdata('failed', 'User not authenticated');
                return redirect()->to('/member/membership/card_payment');
            }

            $loggedUser = $session->get('logged_user');
            $email = $loggedUser->email;

            // Inisialisasi Stripe
            \Stripe\Stripe::setApiKey(SECRET_KEY);

            try {
                // Buat payment intent di Stripe
                $paymentIntent = \Stripe\PaymentIntent::create([
                    'amount' => $amountInCents,
                    'currency' => 'usd',
                    'payment_method' => $paymentMethodId,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never', // Nonaktifkan metode pembayaran berbasis redirect
                    ],
                ]);

                if ($paymentIntent->status === 'requires_confirmation') {
                    $confirmedPaymentIntent = $paymentIntent->confirm();

                    // Jika pembayaran berhasil, simpan ke API
                    if ($confirmedPaymentIntent->status === 'succeeded') {
                        // Siapkan data untuk API
                        $postData = [
                            'email' => $email,
                            'amount' => $amount,
                            'payment_method' => 'card',
                            'transaction_id' => $confirmedPaymentIntent->id
                        ];

                        $url = URLAPI . "/v1/subscribe/paid_subscribe";
                        $response = satoshiAdmin($url, json_encode($postData));

                        $result = $response->result;

                        // Periksa kode response dari API
                        if (isset($result->code) && $result->code != 201) {
                            // Jika API gagal, refund pembayaran
                            \Stripe\Refund::create([
                                'payment_intent' => $confirmedPaymentIntent->id
                            ]);

                            session()->setFlashdata('failed', $result->message ?? 'An error occurred on the API server. Please try again or contact customer support.');
                            return redirect()->to('/member/membership/card_payment');
                        }

                        // Hapus data pembayaran dari session
                        $session->remove('payment_data');

                        // Set flash data untuk sukses
                        session()->setFlashdata('success', 'Your payment is being processed and your account will be ready within 48 hours. We will send you an email when your account is active.');
                        return redirect()->to('/member/membership');
                    } else {
                        session()->setFlashdata('failed', 'Payment failed: ' . $confirmedPaymentIntent->status);
                        return redirect()->to('/member/membership/card_payment');
                    }
                } else {
                    session()->setFlashdata('failed', 'Payment failed: ' . $paymentIntent->status);
                    return redirect()->to('/member/membership/card_payment');
                }
            } catch (\Stripe\Exception\CardException $e) {
                // Kartu ditolak
                session()->setFlashdata('failed', 'Card declined: ' . $e->getError()->message);
                return redirect()->to('/member/membership/card_payment');
            } catch (\Stripe\Exception\RateLimitException $e) {
                // Terlalu banyak request
                session()->setFlashdata('failed', 'Too many requests to Stripe. Please try again later.');
                return redirect()->to('/member/membership/card_payment');
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                // Parameter tidak valid
                session()->setFlashdata('failed', 'Invalid parameters: ' . $e->getError()->message);
                return redirect()->to('/member/membership/card_payment');
            } catch (\Stripe\Exception\AuthenticationException $e) {
                // Autentikasi gagal
                session()->setFlashdata('failed', 'Stripe authentication failed. Please contact administrator.');
                return redirect()->to('/member/membership/card_payment');
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                // Koneksi ke Stripe gagal
                session()->setFlashdata('failed', 'Connection to Stripe failed. Please try again later.');
                return redirect()->to('/member/membership/card_payment');
            } catch (\Stripe\Exception\ApiErrorException $e) {
                // Error API Stripe lainnya
                session()->setFlashdata('failed', 'Stripe error: ' . $e->getError()->message);
                return redirect()->to('/member/membership/card_payment');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            session()->setFlashdata('failed', 'An internal error occurred: ' . $e->getMessage());
            return redirect()->to('/member/membership/card_payment');
        }
    }
}
