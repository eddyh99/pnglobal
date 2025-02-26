<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Membership extends BaseController
{
    public function __construct()
    {
        // $session = session();

        // // Jika belum login, redirect ke halaman signin
        // if (!$session->has('logged_user')) {
        //     header("Location: " . BASE_URL . 'member/auth/login');
        //     exit();
        // }

        // // Mendapatkan data user yang tersimpan (sudah login)
        // $loggedUser = $session->get('logged_user');

        // // Pengecekan role: hanya member yang boleh mengakses halaman ini
        // if ($loggedUser->role !== 'member') {
        //     exit();
        // }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Membership - ' . SATOSHITITLE,
            'content'   => 'member/membership/index',
            'extra'     => 'member/membership/js/_js_index',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function set_investment_capital()
    {
        $mdata = [
            'title'     => 'Set Investment Capital - ' . SATOSHITITLE,
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
    public function confirm_payment()
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

            // Ambil data dari request dan pastikan tipe datanya numerik
            $amount = (float) $this->request->getPost('amount');

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

            // Periksa status response dari API
            if ($response->status != 200) {
                log_message('error', 'API Error: Status ' . $response->status);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan pada server API'
                ])->setStatusCode(500);
            }

            $result = $response->result;

            // Periksa kode response dari API
            if (isset($result->code) && $result->code != 200) {
                log_message('error', 'API Error: Code ' . $result->code . ' - ' . ($result->message ?? 'Unknown error'));
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $result->message ?? 'Terjadi kesalahan pada server API'
                ])->setStatusCode(400);
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dikonfirmasi',
                'data' => [
                    'email' => $email,
                    'amount' => $amount,
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function payment_option()
    {
        $mdata = [
            'title'     => 'Payment Option - ' . SATOSHITITLE,
            'content'   => 'member/membership/payment_option',
            'extra'     => 'member/membership/js/_js_payment_option',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdt_payment()
    {
        $mdata = [
            'title'     => 'USDT Payment - ' . SATOSHITITLE,
            'content'   => 'member/membership/usdt_payment',
            'extra'     => 'member/membership/js/_js_usdt_payment',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdc_payment()
    {
        $mdata = [
            'title'     => 'USDC Payment - ' . SATOSHITITLE,
            'content'   => 'member/membership/usdc_payment',
            'extra'     => 'member/membership/js/_js_usdc_payment',
            'active_membership' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }
}
