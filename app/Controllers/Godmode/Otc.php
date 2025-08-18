<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Otc extends BaseController
{
    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'OTC - ' . NAMETITLE,
            'content'   => check_access('otc','godmode/otc/index','console'),
            'extra'     => 'godmode/otc/js/_js_index',
            'active_otc'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
