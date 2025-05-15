<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
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
            'title'     => 'Course Member - ' . NAMETITLE,
            'content'   => 'godmode/course/message/index',
            'extra'     => 'godmode/course/message/js/_js_index',
            'active_message'    => 'active active-menu',
            'messages'   => $messages
        ];

        return view('course/layout/mentor_wrapper', $mdata);
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
            'content'   => 'godmode/course/message/read',
            'active_message'    => 'active active-menu',
            'message'   => $msg
        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }
}