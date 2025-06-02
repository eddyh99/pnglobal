<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Freemember extends BaseController
{
    protected $validation;

    public function __construct()
    {
        $session = session();
    
        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    
        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');
    
        // Hanya superadmin yang bisa mengakses
        if ($loggedUser->role !== 'superadmin') {
            session()->setFlashdata('failed', "You don't have access to this page");
            session()->unset();
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }


    public function index()
    {
        $mdata = [
            'title'     => 'Free Member - ' . NAMETITLE,
            'content'   => 'godmode/freemember/index',
            'extra'     => 'godmode/freemember/js/_js_index',
            'active_free'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function createfree()
    {
        // Validation Field
        $rules = $this->validate([
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            'referral' => [
                'label' => 'Referral',
                'rules' => 'permit_empty'
            ],
            'expired' => [
                'label' => 'Free Member Expiration Date',
                'rules' => 'required|valid_date'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/freemember');
        }

        // Ambil nilai dari input
        $email    = htmlspecialchars($this->request->getVar('email'));
        $referralInput = $this->request->getVar('referral');
        $expired  = htmlspecialchars($this->request->getVar('expired'));

        // Jika referral tidak diisi atau kosong, set menjadi null
        $referral = (trim($referralInput) === '') ? null : htmlspecialchars($referralInput);

        // Init Data
        $mdata = [
            'email'   => $email,
            'upline'  => $referral,
            'expired' => $expired,
        ];
    
        // Process API Request
        $url = URLAPI2 . "/v1/member/create_freemember";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        log_message('error', json_encode($result));


        if ($result->code == 201) {
            // session()->setFlashdata('success', $result->message);
            // Kirim email ke member
            $email = $mdata['email'];
            $email_template = emailtemplate_new_password($email);
            sendmail_satoshi($email, "Activation Account Satoshi Signal", $email_template);

            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/freemember');
        } else {
            session()->setFlashdata('error', $result->message);
            return redirect()->to(BASE_URL . 'godmode/freemember');
        }
    }


    public function detailmember($email)
    {

        // Call Get Memeber By Email
        $url = URLAPI2 . "/auth/getmember_byemail?email=" . base64_decode($email);
        $resultMember = satoshiAdmin($url)->result->message;

        // Call Get Detail Referral
        $url = URLAPI2 . "/v1/member/detailreferral?id=" . $resultMember->id;
        $resultReferral = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/freemember/detail_freemember',
            'extra'     => 'godmode/freemember/js/_js_detailreferral',
            'active_free'  => 'active',
            'member'    => $resultMember,
            'referral'  => $resultReferral,
            'emailreferral' => base64_decode($email),
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function upgrademember()
    {
        // Init Data
        $mdata = [
            'email'    => $this->request->getVar('email'),
            'expired'  => date_format(date_create($this->request->getVar('expired')), "Y-m-d"),
        ];
    }

    public function cancelfree($email)
    {
        $email  = base64_decode($email);
    }
}
