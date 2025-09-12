<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Member extends BaseController
{
    // public function __construct()
    // {
    //     $session = session();
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    
    //     $loggedUser = $session->get('logged_user');
    
    //     // If role is superadmin, allow full access
    //     if ($loggedUser->role === 'superadmin') {
    //         return;
    //     }
    
    //     // If role is admin, check access
    //     if ($loggedUser->role === 'admin') {
    //         $userAccess = json_decode($loggedUser->access, true);
    //         if (!is_array($userAccess)) {
    //             $userAccess = [];
    //         }
    
    //         if (!in_array('member', $userAccess)) {
    //             session()->setFlashdata('failed', 'You don\'t have access to this page');
    //             header("Location: " . BASE_URL . 'godmode/dashboard');
    //             exit();
    //         }
    
    //         return;
    //     }
    
    //     // For other roles, deny access
    //     session()->setFlashdata('failed', 'You don\'t have access to this page');
    //     header("Location: " . BASE_URL . 'godmode/dashboard');
    //     exit();
    // }


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

    public function getreferral($type)
    {
        // Call Endpoin Get Referral Member
        switch ($type) {
            case 'satoshi':
                $url = URLAPI2 . "/v1/member/referralmember";
                break;
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/referralmember";
                break;
            default:
                $url = URLAPI . "/v1/member/referralmember";
                break;
        }
        // $url = URLAPI . "/v1/member/referralmember";
        // $pnglobal = satoshiAdmin($url)->result->message;

        // $url = URLAPI2 . "/v1/member/referralmember";
        // $satoshi = satoshiAdmin($url)->result->message;

        // $url = URL_HEDGEFUND . "/v1/member/referralmember";
        // $elite = satoshiAdmin($url)->result->message;

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

    public function get_totalmember_elite()
    {
        // Call Endpoin Get Total Member
        $url = URL_HEDGEFUND . "/v1/member/get_all";
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
