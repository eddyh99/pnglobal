<?php

namespace App\Controllers\Godmode\Onetoone;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        //total mentor
        $mentor = URL_COURSE . "/v1/user/mentor";
        $resultmentor = satoshiAdmin($mentor)->result->message;;

        $user = URL_COURSE . "/v1/user/member";
        $resultstudent = satoshiAdmin($user)->result->message;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/onetoone/index',
            'extra'     => 'godmode/course/dashboard/js/_js_index',
            'sidebar'   => 'onetoone_sidebar',
            'navbar_onetoone' => 'active',
            'active_dash'    => 'active',
            'totalstudent'   => count($resultstudent),
            'totalmentor'    => count($resultmentor),
            'student'       => $resultstudent,
            'payment_link'  => session()->getFlashdata('paymentlink')

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
