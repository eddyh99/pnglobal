<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index() {
        $course = [
            'title' => 'Analysis Pattern',
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, expedita.",
            'image' => BASE_URL . 'assets/img/course/course-1.png',
            'author' => 'AC'
        ];

        $courses = array_map(function($index) use ($course) {
            $course['id'] = $index;
            return $course;
        }, range(1, 10));
        
        $mdata = [
            'title'     => 'Course - ' . NAMETITLE,
            'content'   => 'course/index',
            'active_dashboard'    => 'active active-menu',
            'courses' => $courses
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function detail($id) {
        $course = [
            'id' => base64_decode($id),
            'title' => 'Analysis Pattern',
            'description' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, expedita.",
            'video' => BASE_URL . 'assets/img/course/course-1.png',
            'author' => 'AC'
        ];
        $mdata = [
            'title'     => 'Detail Course - ' . NAMETITLE,
            'content'   => 'course/detail',
            'active_dashboard'    => 'active active-menu',
            'course'    => $course
        ];

        return view('course/layout/wrapper', $mdata);
    }


}