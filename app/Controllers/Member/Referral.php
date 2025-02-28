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

        $mdata = [
            'title'     => 'Referral - ' . SATOSHITITLE,
            'content'   => 'member/referral/index',
            'extra'     => 'member/referral/js/_js_index',
            'active_referral'    => 'active',
            'refcode' => $loggedUser->refcode,
        ];
        return view('member/layout/dashboard_wrapper', $mdata);
    }
}
