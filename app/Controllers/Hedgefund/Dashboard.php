<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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
        if (!in_array($loggedUser->role, ['member', 'referral'])) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }
    }

    public function index()
    {

        $wd = new Withdraw;
        $user = session()->get('logged_user');
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'hedgefund/dashboard/index',
            'extra'     => 'hedgefund/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'refcode'   => $_SESSION['logged_user']->refcode,
            'balance'   => $wd->get_balance(),
            'isreferral'   => $user->role == 'referral'
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }


    public function get_trade_history() {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . '/v1/member/history_trade?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }
}
