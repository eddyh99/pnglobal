<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Walletsetting extends BaseController
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
        if ($loggedUser->role !== 'admin') {

            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Wallet Setting - ' . SATOSHITITLE,
            'content'   => 'godmode/walletsetting/index',
            'extra'     => 'godmode/walletsetting/js/_js_index',
            'active_walletsetting' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
