<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
        // Call Endpoin Get All Message
        $url = URLAPI . "/v1/signal/getallmessage";
        $result = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Message - ' . SATOSHITITLE,
            'content'   => 'godmode/message/index',
            'extra'     => 'godmode/message/js/_js_index',
            'active_msg'    => 'active active-menu',
            'message'   => $result
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_allmessage()
    {
        // Call Endpoin Get All Message
        $url = URLAPI . "/v1/signal/getallmessage";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function sendmessage()
    {
        // Validation Field
        $rules = $this->validate([
            'subject'     => [
                'label'     => 'Subject',
                'rules'     => 'required'
            ],
            'message'     => [
                'label'     => 'Message',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('error_validation', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/message');
        }

        // Init Data
        $mdata = [
            'title'     => htmlspecialchars($this->request->getVar('subject')),
            'pesan'     => htmlspecialchars($this->request->getVar('message')),
        ];

        // Proccess Endpoin API
        $url = URLAPI . "/v1/signal/send_message";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        
        
        if($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        }else{
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        }    
    }
}