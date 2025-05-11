<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function inbox()
    {
        $type = $this->request->getVar('type') ?? 'inbox';
        $messages = [
            [
                'sender' => 'john.doe@example.com',
                'subject' => 'Meeting Schedule',
                'sent_date' => '2025-04-30'
            ],
            [
                'sender' => 'jane.smith@example.com',
                'subject' => 'Project Update',
                'sent_date' => '2025-04-29'
            ],
            [
                'sender' => 'mark.jones@example.com',
                'subject' => 'Invoice Details',
                'sent_date' => '2025-04-28'
            ],
            [
                'sender' => 'jane.smith@example.com',
                'subject' => 'Project Update',
                'sent_date' => '2025-04-29'
            ],
            [
                'sender' => 'mark.jones@example.com',
                'subject' => 'Invoice Details',
                'sent_date' => '2025-04-28'
            ]
        ];


        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'course/member/message/' . $type,
            'active_message'    => 'active',
            'sidebar'   => 'course/member/message/sidebar_inbox',
            'active_' . $type => 'active',
            'messages' => $messages
        ];

        return view('course/layout/wrapper', $mdata);
    }

    public function compose()
    {
        $friends = [
            ['id' => 1, 'nama' => 'Principe'],
            ['id' => 2, 'nama' => 'Daniel'],
            ['id' => 3, 'nama' => 'Roberto'],
            ['id' => 4, 'nama' => 'Sophie Dubois'],
            ['id' => 5, 'nama' => 'Liam O\'Connor'],
        ];


        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'course/member/message/compose',
            'active_message'    => 'active',
            'active_compose' => 'active',
            'extra'     => 'course/member/message/js/_js_compose',
            'friends'   => $friends
        ];

        return view('course/layout/wrapper', $mdata);
    }
}
