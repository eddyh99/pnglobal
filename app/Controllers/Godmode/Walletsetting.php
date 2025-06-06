<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Walletsetting extends BaseController
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

    //     // Pengecekan role: hanya admin yang boleh mengakses halaman ini
    //     if ($loggedUser->role !== 'admin') {

    //         exit();
    //     }

    //     if ($loggedUser->role !== 'superadmin') {
    //         $userAccess = json_decode($loggedUser->access, true);
    //         if (!is_array($userAccess)) {
    //             $userAccess = array();
    //         }

    //         if (!in_array('walletsetting', $userAccess)) {
    //             session()->setFlashdata('failed', 'You don\'t have access to this page');
    //             return redirect()->to(BASE_URL . 'godmode/dashboard');
    //             exit();
    //         }
    //     }
    // }

    public function index()
    {
        $mdata = [
            'title'     => 'Wallet Setting - ' . NAMETITLE,
            'content'   => 'godmode/walletsetting/index',
            'extra'     => 'godmode/walletsetting/js/_js_index',
            'active_walletsetting' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
