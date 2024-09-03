<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Referral extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'godmode/referral/index',
            'extra'     => 'godmode/referral/js/_js_index',
            'active_reff'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function sendref()
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
            'refcode'     => [
                'label'     => 'Referral Code',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }

        // Init Data
        $mdata = [
            'email'     => htmlspecialchars($this->request->getVar('email')),
            'password'     => htmlspecialchars($this->request->getVar('password')),
            'timezone'     => $_SESSION['logged_user']->timezone,
            'refcode'     => htmlspecialchars($this->request->getVar('refcode')),
        ];

        // Trim Data
        $mdata['password'] = trim($mdata['password']);

        // Password Encrypt
        $mdata['password'] = sha1($mdata['password']);

        // Proccess Endpoin API
        $url = URLAPI . "/v1/member/create_referral";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        
        if($result->code != '200') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }else{
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }

    }
}