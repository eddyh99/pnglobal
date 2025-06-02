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
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    
        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');
    
        // Jika superadmin, izinkan akses ke semua halaman
        if ($loggedUser->role === 'superadmin') {
            return; // Full access, no checks needed
        }
    
        // Jika admin, periksa akses spesifik
        if ($loggedUser->role === 'admin') {
            $userAccess = json_decode($loggedUser->access, true);
            if (!is_array($userAccess)) {
                $userAccess = [];
            }
            if (!in_array('giveaway', $userAccess)) {
                session()->setFlashdata('failed', 'You don\'t have access to this page');
                header("Location: " . BASE_URL . 'godmode/dashboard');
                exit();
            }
            return; // Allowed access
        }
    
        // Jika bukan superadmin atau admin, tolak akses
        session()->setFlashdata('failed', 'You don\'t have access to this page');
        header("Location: " . BASE_URL . 'godmode/auth/signin');
        exit();
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Giveaway - ' . NAMETITLE,
            'content'   => 'godmode/giveaway/index',
            'extra'     => 'godmode/giveaway/js/_js_index',
            'active_giveaway'    => 'active active-menu',
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active'
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
