<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Member extends BaseController
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
        // Call Endpoin total_member
        $url = URLAPI . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result->message;

        // Call Endpoin total free member
        $url = URLAPI . "/v1/member/total_freemember";
        $resultFreemember = satoshiAdmin($url)->result->message;

        // Call Endpoin total Referral
        $url = URLAPI . "/v1/member/total_exclusive";
        $resultReferral = satoshiAdmin($url)->result->message;

        // Call Endpoin total Message
        $url = URLAPI . "/v1/signal/total_message";
        $resultMessage = satoshiAdmin($url)->result->message;

        // Call Endpoin total Signal
        $url = URLAPI . "/v1/member/total_signal";
        $resultSignal = satoshiAdmin($url)->result->message;



        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalmember' => $resultTotalMember,
            'freemember' => $resultFreemember,
            'referral' => $resultReferral,
            'message' => $resultMessage,
            'signal' => $resultSignal,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }


    public function get_totalmember()
    {
        // Call Endpoin Get Total Member
        $url = URLAPI . "/v1/member/get_all";
        $result = satoshiAdmin($url)->result;
        echo json_encode($result);
    }

    public function get_freemember()
    {
        // Call Endpoin Get Free Member
        $url = URLAPI2 . "/v1/member/freemember";
        $result = satoshiAdmin($url)->result;

        echo json_encode($result);
    }

    public function get_allmember()
    {
        // Mengambil data untuk Satoshi Signal menggunakan URLAPI2
        $url = URLAPI2 . "/v1/member/allmember";
        $result = satoshiAdmin($url)->result;

        echo json_encode($result);
    }

    public function get_referralmember()
    {
        // Call Endpoin Get Referral Member
        $url = URLAPI . "/v1/member/referralmember";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }


    public function get_referraldetail($id)
    {
        // Call Endpoin Get Referral Member
        $url = URLAPI . "/v1/member/detailreferral?id=" . $id;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_totalmember_satoshi()
    {
        // Call Endpoin Get Total Member
        $url = URLAPI2 . "/v1/member/allmember";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_freemember_satoshi()
    {
        // Call Endpoin Get Free Member
        $url = URLAPI2 . "/v1/member/freemember";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_referralmember_satoshi()
    {
        // Call Endpoin Get Referral Member
        $url = URLAPI2 . "/v1/member/referralmember";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }
}
