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
                'sent_date' => '2025-04-30',
                'isread'    => false,
                'isfav'     => true
            ],
            [
                'sender' => 'jane.smith@example.com',
                'subject' => 'Project Update',
                'sent_date' => '2025-04-29',
                'isread'    => false,
                'isfav'     => true
            ],
            [
                'sender' => 'mark.jones@example.com',
                'subject' => 'Invoice Details',
                'sent_date' => '2025-04-28',
                'isread'    => true,
                'isfav'     => false
            ],
            [
                'sender' => 'jane.smith@example.com',
                'subject' => 'Project Update',
                'sent_date' => '2025-04-29',
                'isread'    => true,
                'isfav'     => false
            ],
            [
                'sender' => 'mark.jones@example.com',
                'subject' => 'Invoice Details',
                'sent_date' => '2025-04-28',
                'isread'    => true,
                'isfav'     => false
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

    public function read()
    {
        $msg = [
                'sender' => 'mark.jones@example.com',
                'subject' => 'Invoice Details',
                'sent_date' => '2025-04-28',
                'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta vel perspiciatis a nesciunt repudiandae porro necessitatibus libero consequuntur accusantium laudantium tempora dignissimos error velit ipsam magnam quibusdam, eveniet fugit doloribus earum autem culpa. Vitae cupiditate magni consectetur eius quaerat aperiam enim tenetur aspernatur quis doloremque illo, placeat quod, mollitia iste. Aut unde veniam tenetur perspiciatis reprehenderit suscipit, eum est, sed voluptas expedita vel autem exercitationem, sequi dignissimos dolor rerum fuga nam. Facere, quis molestiae. Doloremque facere minus accusamus eaque consequatur dolor. Omnis nostrum alias eligendi quam nihil ratione. Distinctio dignissimos corrupti totam ad explicabo incidunt neque libero quae facere atque sit illoe.',
                'isread'    => true,
                'isfav'     => false
        ];

        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'course/member/message/read',
            'active_message'    => 'active',
            'active_inbox' => 'active',
            'sidebar'   => 'course/member/message/sidebar_inbox',
            'message'   => $msg
        ];

        return view('course/layout/wrapper', $mdata);
    }
}
