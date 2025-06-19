<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $validation;

    // public function __construct()
    // {
    //     $session = session();
    
    //     // Jika belum login, redirect ke halaman signin
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    
    //     // Mendapatkan data user yang tersimpan (sudah login)
    //     $loggedUser = $session->get('logged_user');
    
    //     // Hanya superadmin yang bisa mengakses
    //     if ($loggedUser->role !== 'superadmin') {
    //         session()->setFlashdata('failed', "You don't have access to this page");
    //         session()->unset();
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    // }


    public function index()
    {
        $product = [
            'hedgefund' => [
                'access' => [
                    'dashboard',
                    'payment',
                    'referral',
                ],
            ],
            'luxbtc' => [
                'access' => [
                    'dashboard',
                    'referral',
                ],
            ],
        ];
        
        $mdata = [
            'title'     => 'Admin - ' . NAMETITLE,
            'content'   => 'godmode/admin/index',
            'extra'     => 'godmode/admin/js/_js_index',
            'sidebar'   => 'hedgefund_sidebar',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active',
            'active_admin'    => 'active active-menu',
            'product'   => $product
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function create_admin()
    {
        $rules = $this->validate([
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email',
            ],
            'alias'     => [
                'label'     => 'Alias',
                'rules'     => 'required',
            ],
        ]);

        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/admin');
        }

        $access = array_column($this->request->getVar('products'), 'access', 'name');

        $mdata = [
            'email'     => $this->request->getVar('email'),
            'password'  => sha1('12345678'),
            'role'      => 'admin',
            'timezone'  => $this->request->getVar('timezone'),
            'ip_address'  => $this->request->getIPAddress(),
            'access'      => $access,
            'alias'       => $this->request->getVar('alias'),
        ];

        // Hash & Trim Password
        $json = json_encode($mdata, JSON_UNESCAPED_SLASHES);

        $url = URLAPI . "/v1/member/add_admin";
        $result = satoshiAdmin($url, $json)->result;


        if ($result->code == '201') {
            // send email
            $subject = "Activation Account - LUX BROKER";
            sendmail_satoshi($mdata['email'], $subject,  emailtemplate_activation_account($result->message->otp, $mdata['email'],"PNGLOBAL", 'godmode/auth/forgot_pass_otp/'),"LUX BROKER",USERNAME_MAIL);

            session()->setFlashdata('success', 'Admin created successfully');
            return redirect()->to(BASE_URL . 'godmode/admin');
        } else {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/admin');
        }
    }

    public function get_admin()
    {
        $url = URLAPI . "/v1/member/get_admin";
        $response = satoshiAdmin($url);
        $result = $response->result;
        $data = [
            'code' => $result->code,
            'message' => $result->message
        ];
        return json_encode($data);
    }
}
