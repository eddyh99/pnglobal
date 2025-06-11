<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
        $admin_course_id  = satoshiAdmin(URL_COURSE . "/v1/user/user_byemail?email=".$_SESSION["logged_user"]->email)->result->message->id;

        $qmessage = satoshiAdmin(URL_COURSE . "/v1/message/all_message?id=".$admin_course_id)->result;
        $messages = $qmessage->message ?? null;

        $response = satoshiAdmin(URL_COURSE . "/v1/user/member_email");
        $result = $response->result ?? [];

        $mdata = [
            'title'     => 'Messages - ' . NAMETITLE,
            'content'   => 'godmode/course/message/index',
            'extra'     => 'godmode/course/message/js/_js_index',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_message'    => 'active active-menu',
            'messages'   => $messages,
            'member'     => $result->message,
            'url'   => 'godmode/course/'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function read($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'godmode/course/message');
        }
        
        $qmessage = satoshiAdmin(URL_COURSE . "/v1/message/message_byid?id=".$id)->result;
        $msg = $qmessage->message ?? null;
        

        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'godmode/course/message/read',
            'active_message'    => 'active active-menu',
            'message'   => $msg,
            'url'   => 'godmode/course/'
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function send_message(){
        $isValid = $this->validate([
            'subject' => [
                'label' => 'Subject',
                'rules' => 'required',
            ],
            'message' => [
                'label' => 'Message Content',
                'rules' => 'required',
            ],
            'member' => [
                'label' => 'To',
                'rules' => 'required'
            ],
        ]);

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/message')->withInput();
        }
        
        $member = $this->request->getVar('member');
        $admin_course_id  = satoshiAdmin(URL_COURSE . "/v1/user/user_byemail?email=".$_SESSION["logged_user"]->email)->result->message->id;

        $mdata = array();
        foreach ($member as $dt){
            $temp["sender_id"] = $admin_course_id;
            $temp["receiver_id"] = $dt;
            $temp["subject"] = htmlspecialchars($this->request->getVar('subject'));
            $temp["content"] = $this->request->getVar('message');

            array_push($mdata,$temp);
        }
        
        $response = satoshiAdmin(URL_COURSE . "/v1/message/send_message", json_encode($mdata));
        $result = $response->result;
        if (@$result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/message')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/course/message');

    }
}