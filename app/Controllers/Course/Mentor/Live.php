<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Live extends BaseController
{
    public function index() {
        $mdata = [
            'title'     => 'Live - ' . NAMETITLE,
            'content'   => 'godmode/course/live/index',
            'extra'     => 'godmode/course/live/js/_js_index',
            'active_live'    => 'active active-menu',
        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }
}