<?php

namespace App\Controllers\Widget;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
        // Call Endpoin Get All Message
        $url = URLAPI . "/v1/signal/getallmessage";
        $result = satoshiAdmin($url)->result->message;


        $mdata = [
            'title'     => 'Message - ' . SATOSHITITLE ,
            'content'   => 'widget/message/index',
            'extra'     => 'widget/message/js/_js_index',
            'message'   => $result
        ];

        return view('widget/layout/wrapper', $mdata);
    }

    public function detailmessage($id)
    {
        
        // Call Endpoin Get All Message
        $url = URLAPI . "/v1/signal/getmessage_byid?id=".base64_decode($id);
        $result = satoshiAdmin($url)->result->message;


        $mdata = [
            'title'     => 'Message - ' . SATOSHITITLE ,
            'content'   => 'widget/message/detailmessage',
            'extra'     => 'widget/message/js/_js_index',
            'detail'    => $result
        ];

        return view('widget/layout/wrapper', $mdata);
    }
}