<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{

    // public function __construct()
    // {
    //     $session = session();

    //     // Jika belum login, redirect ke halaman signin
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'member/auth/login');
    //         exit();
    //     }

    //     // Mendapatkan data user yang tersimpan (sudah login)
    //     $loggedUser = $session->get('logged_user');

    //     if (!in_array($loggedUser->role, ['member', 'referral'])) {
    //         header("Location: " . BASE_URL . 'godmode/signal');
    //         exit();
    //     }
    // }

    public function index()
    {

        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        $start_date = $loggedUser->start_date;
        $end_date = $loggedUser->end_date;
        $date_now = date('Y-m-d H:i:s');
        $day_remaining = (strtotime($end_date) - strtotime($date_now)) / 86400;
        $day_remaining = floor($day_remaining);

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'member/dashboard/index',
            'extra'     => 'member/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'capital' => $loggedUser->initial_capital,
            'refcode' => $loggedUser->refcode,
            'api_key' => $loggedUser->api_key,
            'api_secret' => $loggedUser->api_secret,
            'end_date' => $loggedUser->end_date,
            'day_remaining' => $day_remaining,
        ];
        return view('member/layout/dashboard_wrapper', $mdata);
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
}
