<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $validation;

    public function __construct()
    {
        $session = session();
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        if ($_SESSION["logged_user"]->role != 'admin') {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title'     => 'Admin - ' . SATOSHITITLE,
            'content'   => 'godmode/admin/index',
            'extra'     => 'godmode/admin/js/_js_index',
            'active_admin'    => 'active active-menu'
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
            'password'  => [
                'label'     => 'Password',
                'rules'     => 'required',
            ],
            'access'    => [
                'label'     => 'Access',
                'rules'     => 'required',
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

        $mdata = [
            'email'     => $this->request->getVar('email'),
            'password'  => $this->request->getVar('password'),
            'role'      => 'admin',
            'timezone'  => $this->request->getVar('timezone'),
            'ip_address'    => $this->request->getIPAddress(),
            'access'      => $this->request->getVar('access'),
            'alias'       => $this->request->getVar('alias'),
        ];

        // Hash & Trim Password
        $mdata['password'] = sha1(trim($mdata['password']));
        $json = json_encode($mdata, JSON_UNESCAPED_SLASHES);

        $url = URLAPI . "/v1/member/add_admin";
        $result = satoshiAdmin($url, $json)->result;

        if ($result->code == '201') {
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
