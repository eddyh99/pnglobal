<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Referral extends BaseController
{
    protected $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'admin') {

            exit();
        }

        if ($loggedUser->role !== 'superadmin') {
            $userAccess = json_decode($loggedUser->access, true);
            if (!is_array($userAccess)) {
                $userAccess = array();
            }
            if (!in_array('referral', $userAccess)) {
                session()->setFlashdata('failed', 'You don\'t have access to this page');
                return redirect()->to(BASE_URL . 'godmode/dashboard');
                exit();
            }
        }
    }

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

    public function createreferral()
    {
        // Validation Field
        $rules = $this->validate([
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email'
            ],
            'refcode'     => [
                'label'     => 'Referral Code',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('error_validation', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/referral');
        }

        // Init Data
        $mdata = [
            'email'     => htmlspecialchars($this->request->getVar('email')),
            'refcode'   => htmlspecialchars($this->request->getVar('refcode')),
            'upline'    => htmlspecialchars($this->request->getVar('upline')),
        ];
    }

    public function detailreferral($type, $email)
    {
        // Decode Type
        $finaltype = base64_decode($type);

        // Call Get Memeber By Email
        $url = URLAPI . "/auth/getmember_byemail?email=" . base64_decode($email);
        $resultMember = satoshiAdmin($url)->result->message;

        // Call Get Detail Referral
        $url = URLAPI . "/v1/member/detailreferral?id=" . $resultMember->id;
        $resultReferral = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/referral/detail_referral',
            'extra'     => 'godmode/referral/js/_js_detailreferral',
            'active_reff'  => 'active',
            'member'    => $resultMember,
            'type'      => $finaltype,
            'referral'  => $resultReferral,
            'emailreferral' => base64_decode($email),
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function payreferral($type, $email)
    {
        // Init Data
        $mdata = [
            'id'    => htmlspecialchars($this->request->getVar('id')),
            'type'  => htmlspecialchars($this->request->getVar('type')),
        ];
    }

    public function cancelreferral($email)
    {
        $email  = base64_decode($email);

        // $url = URLAPI . "/v1/referral/cancel_referral?email=".$email;
        // $response = satoshiAdmin($url);
        // $result = $response->result;
        // if($result->code != '200') {
        //     session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
        //     return redirect()->to(BASE_URL . 'godmode/referral/detailreferral/' . base64_encode($email));
        // }else{
        //     session()->setFlashdata('success', "Success Cancelled");
        //     return redirect()->to(BASE_URL . 'godmode/dashboard/detailmember/'.base64_encode('totalmember').'/'. base64_encode($email));
        // }    
    }
}
