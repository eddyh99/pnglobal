<?php

namespace App\Controllers\Elite;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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

        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');
        $wd = new Withdraw;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'elite/dashboard/index',
            'extra'     => 'elite/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'refcode'   => $loggedUser->refcode,
            'balance'   => $wd->get_balance()
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    /**
     * Mengambil data riwayat membership untuk ditampilkan melalui AJAX
     */
    public function get_membership_history()
    {
        $session = session();

        // Jika belum login, kembalikan response error
        if (!$session->has('logged_user')) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Unauthorized access'
            ])->setStatusCode(401);
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');
        $userId = $loggedUser->id;

        // Using the provided API URL with satoshiAdmin helper
        $apiUrl = URLAPI . "/v1/member/membership_history?member_id=" . $userId;

        // Call the API using satoshiAdmin helper
        $apiResponse = satoshiAdmin($apiUrl);

        // Check if API response is valid
        if (!$apiResponse || $apiResponse->status != 200 || !isset($apiResponse->result->message)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => "Invalid API response"
            ])->setStatusCode(500);
        }

        // Return API response data
        return $this->response->setJSON([
            'status' => true,
            'message' => $apiResponse->result->message
        ])->setStatusCode(200);
    }

    public function get_trade_history() {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_ELITE . '/v1/member/history_trade?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }
}
