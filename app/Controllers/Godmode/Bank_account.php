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
        $mdata = [
            'title'     => 'Mediation - ' . NAMETITLE,
            'content'   => 'godmode/bank_account/index',
            'extra'     => 'godmode/bank_account/js/_js_index',
            'active_bank_account'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_bank_account()
    {
        // Call Endpoin
        $url = URLAPI . "/non/bank-account";
        $result = satoshiAdmin($url);
        echo json_encode(is_array($result) ? $result : (array) $result);
        // echo json_encode($result);
        exit;
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
        // dd($mdata);
        $url = URLAPI . "/v1/bank/create-bank-account";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 201) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'Bank account successfully added.');
        } else {
            $error = $result->messages->email ?? 'Failed to add bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

    public function edit()
    {
        $mdata = [
            'title'     => 'Mediation - ' . NAMETITLE,
            'content'   => 'godmode/bank_account/update',
            'extra'     => 'godmode/bank_account/js/_js_update',
            'active_bank_account'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function update()
    {
        $bank_account_name   = $this->request->getVar('bank_account_name');
        $bank_account_type   = $this->request->getVar('bank_account_type');
        $bank_routing_number = $this->request->getVar('bank_routing_number');
        $bank_account_number = $this->request->getVar('bank_account_number');

        // Data yang akan dikirim ke API
        $postData = json_encode([
            'bank_account_name'   => $bank_account_name,
            'bank_account_type'   => $bank_account_type,
            'bank_routing_number' => $bank_routing_number,
            'bank_account_number' => $bank_account_number,
        ]);

        // Panggil API update bank account
        $url = URLAPI . '/v1/bank/update-bank-account';
        $result = satoshiAdmin($url, $postData);
        // return print_r($result); exit;

        if ($result->status == 200 && isset($result->result->success) && $result->result->success) {
            session()->setFlashdata('success', 'Bank account updated successfully.');
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        } else {
            $errorMsg = 'Failed to update bank account.';

            if (isset($result->result->message)) {
                // Pesan error tunggal
                $errorMsg = $result->result->message;
            } elseif (isset($result->result->messages) && is_object($result->result->messages)) {
                // Gabungkan semua pesan error field
                $errorArray = [];
                foreach ($result->result->messages as $field => $msg) {
                    $errorArray[] = $msg;
                }
                $errorMsg = implode(' ', $errorArray);
            }

            session()->setFlashdata('failed', $errorMsg);
            return redirect()->to(BASE_URL . 'godmode/bank_account/edit');
        }
    }
}
