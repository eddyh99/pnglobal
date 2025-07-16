<?php

namespace App\Controllers\Godmode\Onetoone;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    public function index()
    {
        // $user = URL_COURSE . "/v1/user/member";
        // $resultstudent = satoshiAdmin($user)->result->message;

        $mdata = [
            'title'     => 'One To One - ' . NAMETITLE,
            'content'   => 'godmode/onetoone/payment',
            // 'extra'     => 'godmode/course/user/js/_js_member',
            'extra'     => 'godmode/course/dashboard/js/_js_index',
            'sidebar'   => 'onetoone_sidebar',
            'navbar_onetoone' => 'active',
            'active_member'    => 'active active-menu',
            // 'student'       => $resultstudent,
            'student'       => [],
            'payment_link'  => session()->getFlashdata('paymentlink')
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}
