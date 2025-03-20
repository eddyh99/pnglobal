<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Referral extends BaseController
{

    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya member yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'member/auth/pricing');
            exit();
        }
    }

    public function index()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        $loggedUser = $session->get('logged_user');
        $id_member = $loggedUser->id;

        $url = URLAPI . '/v1/member/referral_summary?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        $referral = $result->result->message->referral;
        $commission = $result->result->message->commission;

        $mdata = [
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'member/referral/index',
            'extra'     => 'member/referral/js/_js_index',
            'active_referral'    => 'active',
            'refcode' => $loggedUser->refcode,
            'referral' => $referral,
            'commission' => $commission,
        ];
        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function get_summary()
    {
        $session = session();

        $loggedUser = $session->get('logged_user');
        $id_member = $loggedUser->id;

        $url = URLAPI . '/v1/member/referral_summary?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_referral()
    {
        $session = session();

        $loggedUser = $session->get('logged_user');
        $id_member = $loggedUser->id;

        $url = URLAPI . '/v1/member/list_downline?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_commission()
    {
        $session = session();

        $loggedUser = $session->get('logged_user');
        $id_member = $loggedUser->id;

        $url = URLAPI . '/v1/member/list_commission?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }
}
