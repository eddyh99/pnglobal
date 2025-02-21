<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        if ($_SESSION["logged_user"]->role != 'admin') {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Admin - ' . SATOSHITITLE,
            'content'   => 'godmode/admin/index',
            'extra'     => 'godmode/admin/js/_js_index',
            'active_admin'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
