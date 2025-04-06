<?php

namespace App\Controllers\Elite;

use App\Controllers\BaseController;

class Referral extends BaseController
{

    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }

        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya member yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'elite/auth/pricing');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'elite/referral/index',
            'extra'     => 'elite/referral/js/_js_index',
            'active_referral'    => 'active',
            'refcode'   => $_SESSION['logged_user']->refcode,
        ];
        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    public function get_summary()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url        =  URL_ELITE . '/v1/member/referral_summary?id_member='. $id_member;
        $result     = satoshiAdmin($url);
        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_referral()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_ELITE . '/v1/member/list_downline?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_commission()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_ELITE . '/v1/member/list_commission?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }
}
