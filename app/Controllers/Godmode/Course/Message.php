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
        
        $response = satoshiAdmin(URL_COURSE . "/v1/message/update_status?id=".$id."&status=is_read");

        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'godmode/course/message/read',
            'active_message'    => 'active active-menu',
            'message'   => $msg,
            'url'   => 'godmode/course/'
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function del($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'godmode/course/message');
        }
        
        $result = satoshiAdmin(URL_COURSE . "/v1/message/delete_byid?id=".$id)->result;
        if (@$result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/message')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/course/message');
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
    
    public function updatestatus(){
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
    
        // Basic validation
        if (!in_array($status, ['is_read', 'is_fav']) || !is_numeric($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid input.'
            ]);
        }

        $response = satoshiAdmin(URL_COURSE . "/v1/message/update_status?id=".$id."&status=".$status);
        $result = $response->result;
        if (@$result->code != 200) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Update failed or no change occurred.',
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => ucfirst($status) . ' status updated.',
        ]);
   }
}