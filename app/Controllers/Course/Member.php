<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Member extends BaseController
{

    public function __construct() {
        $user = session()->get('logged_usercourse');
        
        if (!isset($user) || $user->role != 'member') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
    

    public function index() {
        return redirect()->to(BASE_URL . 'course/member/explore');
    }

    public function explore() {        
        $mdata = [
            'title'     => 'Course - ' . NAMETITLE,
            'content'   => 'course/member/index',
            'extra'   => 'course/member/js/_js_index',
            'active_explore'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function detail_course($id) {
        $url = URL_COURSE . "/v1/course/course_byid?id=".base64_decode($id);
        $response = courseAdmin($url);
        $result = $response->result;
        $course = [];

        if($result->code == 200) {
            $course = $result->message;
        }

        $mdata = [
            'title'     => 'Detail Course - ' . NAMETITLE,
            'content'   => 'course/member/detail',
            'active_explore'    => 'active',
            'course'    => $course
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function live() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/live',
            'extra'     => 'course/member/js/_js_live',
            'active_live'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }


    public function mycourse() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/my/course',
            'menu'      => 'course/member/my/menu',
            'category'      => 'course/member/my/sidebar',
            'active_learning'    => 'active',
            'active_course'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function mycertificate() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/my/certificate',
            'menu'      => 'course/member/my/menu',
            'category'      => 'course/member/my/sidebar',
            'active_learning'    => 'active',
            'active_cert'    => 'active',
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function mydemo() {

        $mdata = [
            'title'     => 'Trade Course - ' . NAMETITLE,
            'extra'   => 'course/member/js/_js_demo',
            'content'   => 'course/member/my/demo',
            'menu'      => 'course/member/my/menu',
            'active_learning'    => 'active',
            'active_demo'    => 'active',
            'istrade'   => true
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function wishlist() {
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
            'content'   => 'course/member/wishlist',
            'courses' => $courses
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function joinlive() {

        $mdata = [
            'title'     => 'Live Course - ' . NAMETITLE,
            'content'   => 'course/member/liveroom',
            'active_live'    => 'active',
            'liveroom' => 'd-none'
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function getall_course()
    {
        $url = URL_COURSE . "/v1/course/all_course";
        $response = courseAdmin($url);
        $result = $response->result;
    
        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }
    
    public function get_live()
    {
        $url = URL_COURSE . "/v1/live/active_live";
        $response = courseAdmin($url);
        $result = $response->result;

        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }


}