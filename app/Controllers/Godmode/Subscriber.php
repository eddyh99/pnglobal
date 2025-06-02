<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Subscriber extends BaseController
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
            session()->unset();
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Subscriber - ' . NAMETITLE,
            'content'   => 'godmode/subscriber/index',
            'extra'     => 'godmode/subscriber/js/_js_index',
            'sidebar'   => 'luxbtc_sidebar',
            'navbar_luxbtc' => 'active',
            'active_dash'   => 'active',
            'subs_free'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_activesubscription(){
        // Call Endpoin Get active subscriber
        $url = URLAPI . "/v1/subscribe/list_subscribers";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode(is_array($result) ? $result : []);

    }

    public function satoshi()
    {
        $mdata = [
            'title'     => 'Subscriber - ' . NAMETITLE,
            'content'   => 'godmode/subscriber/index',
            'extra'     => 'godmode/subscriber/js/_js_index_satoshi',
            'subs_free'    => 'active active-menu',
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active',
            'active_dash'    => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_activesubscription_satoshi(){
        // Call Endpoin Get active subscriber
        $url = URLAPI2 . "/v1/subscription/active_member";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode(is_array($result) ? $result : []);

    }
}
