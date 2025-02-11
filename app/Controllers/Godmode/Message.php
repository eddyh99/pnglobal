<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Message extends BaseController
{
    public function __construct()
    {
        // $session = session();
        // if(!$session->has('logged_user')){
        //     header("Location: ". BASE_URL . 'godmode/auth/signin');
        //     exit();
        // }
        // if ($_SESSION["logged_user"]->role=='message'){
        //     header('HTTP/1.0 403 Forbidden');
        //     exit();
        // }
        
    }

    public function index()
    {
        // Call Endpoin Get All Message
        // $url = URLAPI . "/v1/signal/getallmessage";
        // $result = satoshiAdmin($url)->result->message;

        $result = [];
        
        // Create dummy data as objects
        $msg1 = new \stdClass();
        $msg1->id = 1;
        $msg1->title = 'Pengumuman Maintenance System';
        $msg1->pesan = 'Sistem akan mengalami maintenance pada tanggal 20 April 2024 pukul 00:00 - 03:00 WIB';
        $msg1->created_at = '2024-04-15 10:00:00';
        $msg1->updated_at = '2024-04-15 10:00:00';
        
        $msg2 = new \stdClass();
        $msg2->id = 2;
        $msg2->title = 'Update Fitur Baru';
        $msg2->pesan = 'Kami telah menambahkan beberapa fitur baru untuk meningkatkan pengalaman pengguna';
        $msg2->created_at = '2024-04-10 14:30:00';
        $msg2->updated_at = '2024-04-10 14:30:00';
        
        $msg3 = new \stdClass();
        $msg3->id = 3;
        $msg3->title = 'Informasi Penting';
        $msg3->pesan = 'Mohon pastikan data profil Anda sudah diperbarui sesuai dengan ketentuan terbaru';
        $msg3->created_at = '2024-04-05 09:15:00';
        $msg3->updated_at = '2024-04-05 09:15:00';
        
        $result = [$msg1, $msg2, $msg3];

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
        // $url = URLAPI . "/v1/signal/getallmessage";
        // $result = satoshiAdmin($url)->result->message;
        // echo json_encode($result);

        $result = [];
        
        // Create dummy data as objects
        $msg1 = new \stdClass();
        $msg1->id = 1;
        $msg1->title = 'Pengumuman Maintenance System';
        $msg1->pesan = 'Sistem akan mengalami maintenance pada tanggal 20 April 2024 pukul 00:00 - 03:00 WIB';
        $msg1->created_at = '2024-04-15 10:00:00';
        $msg1->updated_at = '2024-04-15 10:00:00';
        
        $msg2 = new \stdClass();
        $msg2->id = 2;
        $msg2->title = 'Update Fitur Baru';
        $msg2->pesan = 'Kami telah menambahkan beberapa fitur baru untuk meningkatkan pengalaman pengguna';
        $msg2->created_at = '2024-04-10 14:30:00';
        $msg2->updated_at = '2024-04-10 14:30:00';
        
        $msg3 = new \stdClass();
        $msg3->id = 3;
        $msg3->title = 'Informasi Penting';
        $msg3->pesan = 'Mohon pastikan data profil Anda sudah diperbarui sesuai dengan ketentuan terbaru';
        $msg3->created_at = '2024-04-05 09:15:00';
        $msg3->updated_at = '2024-04-05 09:15:00';
        
        $result = [$msg1, $msg2, $msg3];
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
        if(!$rules){
            session()->setFlashdata('error_validation', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/message');
        }

        // Init Data
        $mdata = [
            'title'     => htmlspecialchars($this->request->getVar('subject'), ENT_COMPAT),
            'pesan'     => htmlspecialchars($this->request->getVar('message'), ENT_COMPAT),
        ];
    }
}
