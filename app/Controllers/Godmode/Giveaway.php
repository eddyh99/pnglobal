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
            'title'     => 'Giveaway - ' . NAMETITLE,
            'content'   => 'godmode/giveaway/index',
            'extra'     => 'godmode/giveaway/js/_js_index',
            'active_giveaway'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_giveaway()
    {
        // Call Endpoin Get Total Member
        $url = URLAPI2 . "/v1/referral/get_giveaway";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function sendbonus()
    {
        // Init Data
        $gid    = $this->request->getVar('gid');
        $mdata = [
            'email'   => htmlspecialchars($this->request->getVar('email')),
            'amount'  => htmlspecialchars($this->request->getVar('amount')),
        ];

        // Proccess Endpoin API
        $url = URLAPI2 . "/v1/payment/send_bonus?type=giveaway&idgive=" . $gid;
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/giveaway');
        } else {
            session()->setFlashdata('success', "Bonus has been successfully sent");
            return redirect()->to(BASE_URL . 'godmode/giveaway');
        }
    }
}
