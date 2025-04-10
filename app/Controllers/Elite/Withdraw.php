<?php

namespace App\Controllers\Elite;

use App\Controllers\BaseController;

class Withdraw extends BaseController
{
    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'elite/auth/login');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'elite/withdraw/index',
            'extra' => 'elite/withdraw/js/_js_index',
            'active_withdraw' => 'active',
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    public function usdt()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'elite/withdraw/usdt',
            'extra' => 'elite/withdraw/js/_js_usdt',
            'active_withdraw' => 'active',
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    public function usdc()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'elite/withdraw/usdc',
            'extra' => 'elite/withdraw/js/_js_usdc',
            'active_withdraw' => 'active',
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    public function btc()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'elite/withdraw/btc',
            'extra' => 'elite/withdraw/js/_js_btc',
            'active_withdraw' => 'active',
        ];

        return view('elite/layout/dashboard_wrapper', $mdata);
    }

    public function available_commission()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url        =  URL_ELITE . '/v1/member/referral_summary?id_member='. $id_member;
        $result     = satoshiAdmin($url)->result;

        return $this->response->setJSON([
            'code'      => $result->code,
            'message'   => $result->message
        ]);
    }

    public function request_withdraw()
    {
        $rules = $this->validate([
            'type' => [
                'label' => 'Type',
                'rules' => 'required|in_list[fiat,usdt]'
            ],
            'recipient' => [
                'label' => 'Recipient',
                'rules' => 'permit_empty'
            ],
            'routing_number' => [
                'label' => 'Routing Number',
                'rules' => 'permit_empty'
            ],
            'account_type' => [
                'label' => 'Account Type',
                'rules' => 'permit_empty|in_list[checking,saving]'
            ],
            'swift_code' => [
                'label' => 'SWIFT Code',
                'rules' => 'permit_empty'
            ],
            'wallet_address' => [
                'label' => 'Wallet Address',
                'rules' => 'permit_empty'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'permit_empty'
            ],
            'network' => [
                'label' => 'Network',
                'rules' => 'permit_empty'
            ],
        ]);

        if (!$rules) {
            return $this->response->setJSON([
                'code' => 400,
                'message' => $this->validator->listErrors()
            ]);
        }

        $session = session();
        $loggedUser = $session->get('logged_user');
        $member_id = $loggedUser->id;

        $mdata = [
            'amount' => $this->request->getVar('amount'),
            'type' => $this->request->getVar('type'),
            'member_id' => $member_id,
            'recipient' => $this->request->getVar('recipient'),
            'routing_number' => $this->request->getVar('routing_number'),
            'account_type' => $this->request->getVar('account_type'),
            'swift_code' => $this->request->getVar('swift_code'),
            'wallet_address' => $this->request->getVar('wallet_address'),
            'address' => $this->request->getVar('address'),
            'network' => $this->request->getVar('network'),
        ];

        $url = URLAPI . "/v1/withdraw/request_payment";
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        // Jika kode respons adalah 201, redirect ke halaman withdraw
        if ($result->code == 201) {
            return $this->response->setJSON([
                'code' => $result->code,
                'message' => $result->message
            ]);
        } else {
            return $this->response->setJSON([
                'code' => $result->code,
                'message' => $result->message
            ]);
        }

        // return $this->response->setJSON([
        //     'code' => $result->code,
        //     'message' => $result->message
        // ]);
    }

    public function get_withdraw_history()
    {
        $member_id = $_SESSION["logged_user"]->id;

        $url = URL_ELITE . "/v1/member/history_payment?id_member=" . $member_id;
        $result = satoshiAdmin($url)->result;

        return $this->response->setJSON([
            'code' => $result->code,
            'message' => $result->message
        ]);
    }
}
