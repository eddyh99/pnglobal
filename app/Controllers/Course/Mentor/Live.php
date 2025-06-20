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

    
    public function host() {

        $user = session()->get('logged_user');
        $roomId = $_GET['room_id'];
        $url =  URL_COURSE . "/v1/live/live_byroomid?roomid=" . $roomId;
        $response = courseAdmin($url)->result->message;
        $end_time = $response->end_date;
        $mdata = [
            'title'     => 'Live - ' . NAMETITLE,
            'content'   => 'godmode/course/live/livestream',
            'extra'     => 'godmode/course/live/js/_js_livestream',
            'liveroom' => 'd-none',
            'user'    => explode('@', $user->email)[0],
            'mentor'    => $result->message ?? [],
            'end_time' =>  date('c', strtotime($end_time)),
            'isgodmode' => false
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    } 
}