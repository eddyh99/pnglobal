<?php

namespace App\Controllers\Course;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function inbox()
    {
        $type = $this->request->getVar('type') ?? 'inbox';

        $qmessage = courseAdmin(URL_COURSE . "/v1/message/all_message?id=".$_SESSION["logged_usercourse"]->id)->result;
        $messages = $qmessage->message ?? null;
        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'course/member/message/' . $type,
            'extra'     => 'course/member/message/js/_js_inbox',
            'active_message'    => 'active',
            'sidebar'   => 'course/member/message/sidebar_inbox',
            'active_' . $type => 'active',
            'messages' => $messages
        ];

        return view('course/layout/wrapper', $mdata);
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

        $response = courseAdmin(URL_COURSE . "/v1/message/update_status?id=".$id."&status=".$status);
        $result = $response->result;
        if (@$result->code != 200) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $result->message//'Update failed or no change occurred.',
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => ucfirst($status) . ' status updated.',
        ]);
    }    
   

    public function del($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'course/message/inbox');
        }
        
        $result = courseAdmin(URL_COURSE . "/v1/message/delete_byid?id=".$id)->result;
        if (@$result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/message/inbox')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'course/message/inbox');
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
            'to' => [
                'label' => 'To',
                'rules' => 'required'
            ],
        ]);

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'course/message/compose')->withInput();
        }
        

        $mdata = [[
                "sender_id"     => $_SESSION["logged_usercourse"]->id,
                "receiver_id"   => $this->request->getVar('to'),
                "subject"       => htmlspecialchars($this->request->getVar('subject')),
                "content"       => $this->request->getVar('message'),
            ]];
    

        $response = courseAdmin(URL_COURSE . "/v1/message/send_message", json_encode($mdata));
        $result = $response->result;
        if (@$result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/message/inbox')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'course/message/inbox');

    }
    
    public function compose()
    {
        $response = courseAdmin(URL_COURSE . "/v1/user/mentor");
        $result = $response->result->message;
        
        $friends=array();
        foreach ($result as $dt){
            $temp["id"]     = $dt->id;
            $temp["nama"]   = strstr($dt->email, '@', true);
            array_push($friends, $temp);
        }

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

   public function read($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'course/message/inbox');
        }
        
        $qmessage = courseAdmin(URL_COURSE . "/v1/message/message_byid?id=".$id)->result;
        $msg = $qmessage->message ?? null;
        
        $response = courseAdmin(URL_COURSE . "/v1/message/update_status?id=".$id."&status=is_read");

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
