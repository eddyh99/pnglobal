<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Explore extends BaseController
{
    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {

        $mdata = [
            'title'     => 'Explore - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/index',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'active_explore'    => 'active active-menu',
            'url'   => 'godmode/course/'
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }

    public function addnew()
    {
        $url = URL_COURSE . "/v1/user/mentor";
        $result = satoshiAdmin($url)->result;

        $mdata = [
            'title'     => 'Add New - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/addnew',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'active_explore'    => 'active active-menu',
            'mentor'    => $result->message ?? []
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }

    public function store() {
        $isValid = $this->validate([
            'title' => [
                'label' => 'Title Course',
                'rules' => 'required',
            ],
            'mentor_id' => [
                'label' => 'Mentor',
                'rules' => 'required',
            ],
            'description' => [
                'label' => 'Description Course',
                'rules' => 'required',
            ],
            'cover' => [
                'label' => 'Cover Image',
                'rules' => 'uploaded[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]'
            ],
        ]);
        

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
        }

            
        $mdata = [
            'title'        => $this->request->getVar('title'),
            'description'  => $this->request->getVar('description'),
            'mentor_id'    => $this->request->getVar('mentor_id'),
            'cover'        => 'course/course-1.png'
        ];
        $response = satoshiAdmin(URL_COURSE . "/v1/course/store", json_encode($mdata));
        $result = $response->result;
    
        if ($result->code != 201) {    
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
        } 

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/course/explore');
    }
    
}
