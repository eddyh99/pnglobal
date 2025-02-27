<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Giveaway extends BaseController
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
            'title'     => 'Giveaway - ' . SATOSHITITLE,
            'content'   => 'godmode/giveaway/index',
            'extra'     => 'godmode/giveaway/js/_js_index',
            'active_giveaway'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_giveaway()
    {
        // Call Endpoin Get Total Member
        // $url = URLAPI . "/v1/referral/get_giveaway";
        // $result = satoshiAdmin($url)->result->message;
        // echo json_encode($result);
    }

    public function sendbonus()
    {
        // Init Data
        $gid    = $this->request->getVar('gid');
        $mdata = [
            'email'   => htmlspecialchars($this->request->getVar('email')),
            'amount'  => htmlspecialchars($this->request->getVar('amount')),
        ];
    }
}
