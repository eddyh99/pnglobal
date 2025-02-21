<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Withdraw extends BaseController
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

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/index',
            'extra' => 'member/withdraw/js/_js_index',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }
}
