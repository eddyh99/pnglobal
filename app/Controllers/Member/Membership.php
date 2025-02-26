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
     * @return \CodeIgniter\HTTP\Response
     */
    public function confirm_payment()
    {
        // Validasi request
        $rules = [
            'total_capital' => 'required|numeric',
            'payment_amount' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        // Ambil data dari request
        $totalCapital = $this->request->getPost('total_capital');
        $paymentAmount = $this->request->getPost('payment_amount');

        // Di sini Anda bisa menyimpan data ke database atau melakukan proses lainnya
        // Contoh: simpan ke database, kirim email konfirmasi, dll.

        // Untuk contoh ini, kita hanya mengembalikan respons sukses
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Pembayaran berhasil dikonfirmasi',
            'data' => [
                'total_capital' => $totalCapital,
                'payment_amount' => $paymentAmount,
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
