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
}
