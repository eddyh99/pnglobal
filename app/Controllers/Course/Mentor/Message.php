<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
        $qmessage = courseAdmin(URL_COURSE . "/v1/message/all_message?id=".$_SESSION["logged_usercourse"]->id)->result;
        $messages = $qmessage->message ?? null;
        
        $response = courseAdmin(URL_COURSE . "/v1/user/member_email");
        $result = $response->result ?? [];

        $mdata = [
            'title'     => 'Course Member - ' . NAMETITLE,
            'content'   => 'course/mentor/message/index',
            'extra'     => 'course/mentor/message/js/_js_index',
            'active_message'    => 'active active-menu',
            'messages'   => $messages,
            'member'     => $result->message,
            'url'   => 'course/mentor/'
        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }

    public function read($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'course/mentor/message');
        }
        
        $qmessage = courseAdmin(URL_COURSE . "/v1/message/message_byid?id=".$id)->result;
        $msg = $qmessage->message ?? null;
        
        $response = courseAdmin(URL_COURSE . "/v1/message/update_status?id=".$id."&status=is_read");

        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'course/mentor/message/read',
            'active_message'    => 'active active-menu',
            'message'   => $msg,
            'url'   => 'course/mentor/'
        ];

        return view('course/layout/mentor_wrapper', $mdata);
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
            return redirect()->to(BASE_URL . 'course/mentor/message')->withInput();
        }
        
        $member = $this->request->getVar('member');

        $mdata = array();
        foreach ($member as $dt){
            $temp["sender_id"] = $_SESSION["logged_usercourse"]->id;
            $temp["receiver_id"] = $dt;
            $temp["subject"] = htmlspecialchars($this->request->getVar('subject'));
            $temp["content"] = $this->request->getVar('message');

            array_push($mdata,$temp);
        }
        
        $response = courseAdmin(URL_COURSE . "/v1/message/send_message", json_encode($mdata));
        $result = $response->result;
        if (@$result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/mentor/message')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'course/mentor/message');

    }
        
    
    public function del($id=null)
    {
        if (empty($id)){
            session()->setFlashdata('failed', "No message chosen");
            return redirect()->to(BASE_URL . 'course/mentor/message');
        }
        
        $result = courseAdmin(URL_COURSE . "/v1/message/delete_byid?id=".$id)->result;
        if (@$result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/mentor/message')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'course/mentor/message');
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
                'message' => 'Update failed or no change occurred.',
            ]);
        }
        return $this->response->setJSON([
            'success' => true,
            'message' => ucfirst($status) . ' status updated.',
        ]);
   }
}