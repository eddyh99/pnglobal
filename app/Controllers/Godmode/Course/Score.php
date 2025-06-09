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
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_score'    => 'active active-menu',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}