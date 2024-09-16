<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Teamwork extends BaseController
{
    public function index()
    {
        
        $mdata = [
            'title'     => 'Teamwork - ' . NAMETITLE,
            'content'   => 'homepage/teamwork/index',
            'extra'     => 'homepage/teamwork/js/_js_index',
            'extragsap' => 'homepage/teamwork/gsap/gsap_index'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }
}