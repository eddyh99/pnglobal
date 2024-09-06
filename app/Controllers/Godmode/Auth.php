<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function signin()
    {
        $mdata = [
            'title'     => 'Sign in - ' . NAMETITLE,
            'content'   => 'godmode/auth/index',
            'extra'     => 'godmode/auth/js/_js_index',
        ];

        return view('godmode/layout/login_wrapper', $mdata);
    }

    public function auth_proccess()
    {
        // Validation Field
        $rules = $this->validate([
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email'
            ],
            'password'     => [
                'label'     => 'Password',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/auth/signin')->withInput();
        }

        // Initial Data
        $mdata = [
            'email'         => htmlspecialchars($this->request->getVar('email')),
            'password'      => htmlspecialchars($this->request->getVar('password')),
        ];
        
        // Trim Data
        $mdata['password'] = trim($mdata['password']);

        // Password Encrypt
        $mdata['password'] = sha1($mdata['password']);

        // Proccess Endpoin API
        $url = URLAPI . "/auth/signin";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;


        if($response->status != 200 || $result->code != 200) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/auth/signin');
        }else{
            $this->session->set('logged_user', $result->message);
            session()->setFlashdata('success', 'Welcome to admin panel');
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }

        
    }
}