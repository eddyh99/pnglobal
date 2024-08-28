<?php

namespace App\Controllers\godmode;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function signin()
    {
        $mdata = [
            'title'     => 'Sign in - ' . NAMETITLE,
            'content'   => 'godmode/auth/index',
            'extra'     => 'godmode/auth/js/_js_index',
        ];

        return view('godmode/layout/login_wrapper', $mdata);
    }
}