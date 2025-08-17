<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Principe extends BaseController
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
            'title'     => 'Mediation - ' . NAMETITLE,
            'content'   => check_access('calc','godmode/principe/index','hedgefund'),
            'extra'     => 'godmode/principe/js/_js_index',
            'active_principe'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_detailprofit()
    {
        // Call Endpoin
        $url = URL_HEDGEFUND . "/price/detail_profit";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode(is_array($result) ? $result : []);
    }
}
