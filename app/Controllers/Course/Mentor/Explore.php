<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Explore extends BaseController
{

    public function index()
    {

        $mdata = [
            'title'     => 'Explore - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/index',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'active_explore'    => 'active active-menu',
            'url'   => 'course/mentor/'
        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }

    public function addnew()
    {

        $mdata = [
            'title'     => 'Add New - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/addnew',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'active_explore'    => 'active active-menu',

        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }
    
}
