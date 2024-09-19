<?php

namespace App\Controllers\Godmode;
use App\Controllers\BaseController;

class Dashboard extends BaseController
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

        // Call Endpoin total_exclusive
        $url = URLAPI . "/v1/member/total_exclusive";
        $resultExclusive = satoshiAdmin($url)->result->message;

        // Call Endpoin total_member
        $url = URLAPI . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result->message;

        // Call Endpoin total Main Signal
        $url = URLAPI . "/v1/member/total_signal";
        $resultMainSignal = satoshiAdmin($url)->result->message;


        // Call Endpoin total Main Signal
        $url = URLAPI . "/v1/member/total_subsignal";
        $resultSubSignal = satoshiAdmin($url)->result->message;

        
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'exclusive' => $resultExclusive,
            'totalmember' => $resultTotalMember,
            'mainsignal' => $resultMainSignal,
            'subsignal' => $resultSubSignal,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function detailmember()
    {
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/detail_member',
            'extra'     => 'godmode/dashboard/js/_js_detailmember',
            'active_dash'    => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}