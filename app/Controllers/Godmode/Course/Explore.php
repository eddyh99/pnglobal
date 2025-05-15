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
            'active_dash'    => 'active',

        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }

    public function addnew()
    {

        $mdata = [
            'title'     => 'Add New - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/addnew',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'active_dash'    => 'active',

        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
}
