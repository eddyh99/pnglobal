<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Hedge extends BaseController
{

    // public function __construct()
    // {
    //     $session = session();
    //     $loggedUser = $session->get('logged_user');

    //     // Jika belum login, redirect ke halaman signin
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }


    //     // Pengecekan role: hanya admin yang boleh mengakses halaman ini
    //     if ($loggedUser->role == 'member') {
    //         session()->setFlashdata('failed', "You don't have access to this page");
    //         session()->unset();
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    // }

    public function index()
    {
        $mdata = [
            'title'     => 'Subscriber - ' . NAMETITLE,
            'content'   => 'godmode/hedge/index',
            'extra'     => 'godmode/hedge/js/_js_index',
            'subs_free'    => 'active active-menu',
            'active_dash'   => 'active',
            'sidebar'   => 'hedgefund_sidebar',
            'navbar_hedgefund' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function profit()
    {
        $mdata = [
            'title'     => 'Subscriber - ' . NAMETITLE,
            'content'   => 'godmode/hedge/profit',
            'extra'     => 'godmode/hedge/js/_js_profit',
            'subs_free'    => 'active active-menu',
            'active_dash'   => 'active',
            'sidebar'   => 'hedgefund_sidebar',
            'navbar_hedgefund' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_profit()
    {
        // Call Endpoint Get Total Member
        $url = URL_HEDGEFUND . "/price/profit";
        $result = satoshiAdmin($url)->result;
    
        return $this->response->setJSON($result->message);
    }

    public function get_detailprofit(){
        // Call Endpoin Get active subscriber
        $url = URL_HEDGEFUND . "/price/detail_profit";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode(is_array($result) ? $result : []);

    }

    public function get_activemember()
    {
        // Call Endpoin Get Total Member
        $url = URL_HEDGEFUND . "/v1/member/get_all";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

}
