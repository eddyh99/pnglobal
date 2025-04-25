<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login() {
        $mdata = [
            'title'     => 'Login Course - ' . NAMETITLE,
            'content'   => 'course/login',
            'active_dashboard'    => 'active active-menu',
        ];

        return view('elite/layout/wrapper', $mdata);
    }
}