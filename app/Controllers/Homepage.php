<?php

namespace App\Controllers;

class Homepage extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Homepage - ' . NAMETITLE,
            'content'   => 'homepage/index',
            'extra'     => 'homepage/js/_js_index'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }


    public function about()
    {
        echo '<pre>'.print_r("<h1>TESTING AUTO ROUTE</h1>",true).'</pre>';
        die;
    }
}
