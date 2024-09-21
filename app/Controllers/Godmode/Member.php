<?php

namespace App\Controllers\Godmode;
use App\Controllers\BaseController;

class Member extends BaseController
{
    public function __construct()
    {
        $session = session();
        if(!$session->has('logged_user')){
            header("Location: ". BASE_URL . 'godmode/auth/signin');
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
        $url = URLAPI . "/v1/member/allmember";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_freemember()
    {   
        // Call Endpoin Get Free Member
        $url = URLAPI . "/v1/member/freemember";
        $result = satoshiAdmin($url)->result->message;
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
        $url = URLAPI . "/v1/member/detailreferral?id=".$id;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }



}