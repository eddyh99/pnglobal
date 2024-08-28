<?php

namespace App\Controllers\godmode;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}