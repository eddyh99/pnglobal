<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Admin extends BaseController
{
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
        $mdata = [
            'email'     => $this->request->getVar('email'),
            'password'  => $this->request->getVar('password'),
            'role'      => $this->request->getVar('role'),
            'timezone'  => $this->request->getVar('timezone'),
            'ip_address'    => $this->request->getIPAddress(),
        ];

        // Hash & Trim Password
        $mdata['password'] = sha1(trim($mdata['password']));

        $url = URLAPI . "/auth/register";
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        if ($result->code == '201') {
            session()->setFlashdata('success', 'Admin created successfully');
            return redirect()->to(BASE_URL . 'godmode/admin');
        } else {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/admin');
        }
    }
}
