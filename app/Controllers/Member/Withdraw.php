<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Withdraw extends BaseController
{
    // public function __construct()
    // {
    //     $session = session();

    //     // Jika belum login, redirect ke halaman signin
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'member/auth/login');
    //         exit();
    //     }

    //     // Mendapatkan data user yang tersimpan (sudah login)
    //     $loggedUser = $session->get('logged_user');
    //     if (!in_array($loggedUser->role, ['member', 'referral'])) {
    //         header("Location: " . BASE_URL . 'godmode/signal');
    //         exit();
    //     }
    // }

    public function index()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');
        $refcode = $loggedUser->refcode;

        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'member/withdraw/index',
            'extra' => 'member/withdraw/js/_js_index',
            'active_withdraw' => 'active',
            'refcode' => $refcode,
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdt()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'member/withdraw/usdt',
            'extra' => 'member/withdraw/js/_js_usdt',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdc()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'member/withdraw/usdc',
            'extra' => 'member/withdraw/js/_js_usdc',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function international_bank()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'member/withdraw/international_bank',
            'extra' => 'member/withdraw/js/_js_international_bank',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usa_bank()
    {
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'member/withdraw/usa_bank',
            'extra' => 'member/withdraw/js/_js_usa_bank',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function available_commission()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');
        $member_id = $loggedUser->id;

        $mdata = [
            'member_id' => $member_id,
        ];

        $url = URLAPI . "/v1/withdraw/available_commission";
        $result = satoshiAdmin($url, json_encode($mdata))->result;

        return $this->response->setJSON([
            'code' => $result->code,
            'message' => $result->message
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
        $session = session();
        $loggedUser = $session->get('logged_user');
        $member_id = $loggedUser->id;

        $url = URLAPI . "/v1/member/history_payment?id_member=" . $member_id;
        $result = satoshiAdmin($url)->result;

        return $this->response->setJSON([
            'code' => $result->code,
            'message' => $result->message
        ]);
    }
}
