<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Score extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Course Member - ' . NAMETITLE,
            'content'   => 'godmode/course/score/index',
            'extra'     => 'godmode/course/score/js/_js_index',
            'active_score'    => 'active active-menu',
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
}