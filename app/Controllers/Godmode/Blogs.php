<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Blogs extends BaseController
{

    // public function __construct()
    // {
    //     $session = session();
    //     $loggedUser = $session->get('logged_user');

    //     // Jika belum login, redirect ke halaman signin
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }


    //     // Pengecekan role: hanya admin yang boleh mengakses halaman ini
    //     if ($loggedUser->role == 'member') {
    //         session()->setFlashdata('failed', "You don't have access to this page");
    //         session()->unset();
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    // }

    public function index()
    {
        $mdata = [
            'title'     => 'Blogs - ' . NAMETITLE,
            'content'   => 'godmode/blogs/index',
            'extra'     => 'godmode/blogs/js/_js_index',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active',
            'active_blog'    => 'active active-menu',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
    
    public function addnew(){
        $mdata = [
            'title'     => 'New Posts - ' . NAMETITLE,
            'content'   => 'godmode/blogs/addnew',
            'extra'     => 'godmode/blogs/js/_js_tambah',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active',
            'active_blog'    => 'active active-menu',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
        
    }
    
    public function save_post(){
        
        $isValid = $this->validate([
            'title' => [
                'label' => 'Title Post',
                'rules' => 'required',
            ],
            'content' => [
                'label' => 'Post Content',
                'rules' => 'required',
            ],
            'link'  => [
                'label' => 'Post Link',
                'rules' => 'valid_url'
            ]
        ]);


        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/blogs/addnew')->withInput();
        }

        $mdata = [
            'title'        => htmlspecialchars($this->request->getVar('title')),
            'content'      => $this->request->getVar('content'),
            'link'         => $this->request->getVar('link'),
        ];
        

        $response = satoshiAdmin(URLAPI . "/blogs/add_blog", json_encode($mdata));
        $result = $response->result;

        if ($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/blogs/addnew')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/blogs');
    }
    
    public function getall_posts(){
        $response = satoshiAdmin(URLAPI . "/blogs/all_blogs");
        $result = $response->result;
        echo json_encode($result);
    }

    public function upload()
    {
        $file = $this->request->getFile('upload');

        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $path = FCPATH . 'uploads/tmp/'; // Save temporarily
            $file->move($path, $newName);

            return $this->response->setJSON([
                'url' => base_url($path . $newName)
            ]);
        }

        return $this->response->setStatusCode(400)->setJSON([
            'error' => 'Upload failed'
        ]);
    }
}
