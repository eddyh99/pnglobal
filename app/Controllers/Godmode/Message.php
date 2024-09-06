<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'godmode/message/index',
            'extra'     => 'godmode/message/js/_js_index',
            'active_msg'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
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
            session()->setFlashdata('failed', $this->validation->listErrors());
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


        echo '<pre>'.print_r($mdata,true).'</pre>';
        die;
    
    }
}