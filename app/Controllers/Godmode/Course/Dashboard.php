<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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
        //total student
        $url = URL_COURSE ."";
        $resultstudent= 10;

        //total mentor
        $url = URL_COURSE ."";
        $resultmentor = 5;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/course/dashboard/index',
            'extra'     => 'godmode/course/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalstudent'   => $resultstudent,
            'totalmentor'    => $resultmentor 

        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function paymentlink(){
                // Validation Field
        $rules = $this->validate([
            'nominal' => [
                'label' => 'Nominal',
                'rules' => 'required|decimal'
            ],
            'currency' => [
                'label' => 'Currency',
                'rules' => 'required|in_list[usd,eur]'
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/dashboard');
        }

        // Ambil nilai dari input
        $nominal     = htmlspecialchars($this->request->getVar('nominal'));
        $currency    = $this->request->getVar('currency');
        $description = htmlspecialchars($this->request->getVar('description'));
        
        $mdata=array(
                "nominal"       => $nominal,
                "currency"      => $currency,
                "description"   => $description
            );

    }
}
