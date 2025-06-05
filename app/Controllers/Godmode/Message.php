<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Message extends BaseController
{
    // public function __construct()
    // {
    //     $session = session();
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    
    //     $loggedUser = $session->get('logged_user');
    
    //     // Superadmin has full access
    //     if ($loggedUser->role === 'superadmin') {
    //         return;
    //     }
    
    //     // If admin, check access permissions
    //     if ($loggedUser->role === 'admin') {
    //         $userAccess = json_decode($loggedUser->access, true);
    //         if (!is_array($userAccess)) {
    //             $userAccess = [];
    //         }
    
    //         // Example: check if they have 'message' access or customize this key as needed
    //         if (!in_array('message', $userAccess)) {
    //             session()->setFlashdata('failed', 'You don\'t have access to this page');
    //             header("Location: " . BASE_URL . 'godmode/dashboard');
    //             exit();
    //         }
    //         return;
    //     }
    
    //     // If neither superadmin nor admin
    //     session()->setFlashdata('failed', 'You don\'t have access to this page');
    //     header("Location: " . BASE_URL . 'godmode/dashboard');
    //     exit();
    // }


    public function index()
    {
        // Call Endpoin Get All Message
        $url = URLAPI2 . "/v1/signal/getallmessage";
        $result = satoshiAdmin($url)->result;

        $messageData = [];
        if (isset($result) && is_object($result) && isset($result->message)) {
            $messageData = $result->message;
        } elseif (isset($result) && is_array($result)) {
            $messageData = $result;
        }

        $mdata = [
            'title'     => 'Message - ' . NAMETITLE,
            'content'   => 'godmode/message/index',
            'extra'     => 'godmode/message/js/_js_index',
            'active_msg'    => 'active active-menu',
            'message'   => $messageData,
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_allmessage()
    {
        // Call Endpoin Get All Message
        $url = URLAPI2 . "/v1/signal/getallmessage";
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
        if (!$rules) {
            session()->setFlashdata('error_validation', $this->validator->listErrors());
            return redirect()->to(BASE_URL . 'godmode/message');
        }

        // Init Data
        $mdata = [
            'title'     => htmlspecialchars($this->request->getVar('subject'), ENT_COMPAT),
            'pesan'     => htmlspecialchars($this->request->getVar('message'), ENT_COMPAT),
        ];

        // Proccess Endpoin API
        $url = URLAPI2 . "/v1/signal/send_message";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        }
    }

    public function editmessage($msgid)
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
        if (!$rules) {
            session()->setFlashdata('error_validation', $this->validator->listErrors());
            return redirect()->to(BASE_URL . 'godmode/message');
        }

        // Init Data
        $mdata = [
            'title'     => htmlspecialchars($this->request->getVar('subject'), ENT_COMPAT),
            'pesan'     => htmlspecialchars($this->request->getVar('message'), ENT_COMPAT),
        ];

        // Proccess Endpoin API
        $url = URLAPI2 . "/v1/signal/edit_message?msgid=" . $msgid;
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/message');
        }
    }
}
