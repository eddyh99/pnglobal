<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Bank_account extends BaseController
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
        $url = URL_HEDGEFUND . "/non/bank";
        $result = satoshiAdmin($url);
        
        $mdata = [
            'title'     => 'Bank Account - ' . NAMETITLE,
            'content'   => 'godmode/bank_account/index',
            'active_bank_account'    => 'active active-menu',
            'sidebar'        => 'console_sidebar',
            'navbar_console' => 'active',
            'bank'           => @$result->result->data
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function addbankaccount()
    {
        $bank_account_name = $this->request->getVar('bank_account_name');
        $bank_account_type = $this->request->getVar('bank_account_type');
        $bank_routing_number = $this->request->getVar('bank_routing_number');
        $bank_account_number = $this->request->getVar('bank_account_number');

        if (!$this->validate([
            'bank_account_name' => 'required',
            'bank_account_type' => 'required|in_list[checking,saving]',
            'bank_routing_number' => 'required',
            'bank_account_number' => 'required',
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        }

        $mdata = [
            'bank_account_name' => $bank_account_name,
            'bank_account_type' => $bank_account_type,
            'bank_routing_number' => $bank_routing_number,
            'bank_account_number' => $bank_account_number,
        ];
        //dd($mdata);
        $url = URL_HEDGEFUND . "/non/update-bank";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 200) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'Bank account successfully added.');
        } else {
            $error = $result->messages->email ?? 'Failed to add bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

}
