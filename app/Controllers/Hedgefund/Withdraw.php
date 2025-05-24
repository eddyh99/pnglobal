<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;

class Withdraw extends BaseController
{
    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if (!in_array($loggedUser->role, ['member', 'referral'])) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }
    }

    public function index()
    {
        $balance = $this->get_balance();
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'hedgefund/withdraw/index',
            'extra' => 'hedgefund/withdraw/js/_js_index',
            'balance' => $balance,
            'active_withdraw' => 'active',
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function usdt()
    {
        $balance = $this->get_balance();
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'hedgefund/withdraw/usdt',
            'extra' => 'hedgefund/withdraw/js/_js_usdt',
            'balance' => $balance,
            'active_withdraw' => 'active',
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function usdc()
    {
        $balance = $this->get_balance();
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'hedgefund/withdraw/usdc',
            'extra' => 'hedgefund/withdraw/js/_js_usdc',
            'balance' => $balance,
            'active_withdraw' => 'active',
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function btc()
    {
        $balance = $this->get_balance();
        $mdata = [
            'title' => 'Withdraw - ' . NAMETITLE,
            'content' => 'hedgefund/withdraw/btc',
            'extra' => 'hedgefund/withdraw/js/_js_btc',
            'balance' => $balance,
            'active_withdraw' => 'active',
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function available_commission()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url        =  URL_HEDGEFUND . '/v1/member/referral_summary?id_member='. $id_member;
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
                'rules' => 'required|in_list[fiat,usdt,usdc, btc]'
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
            'amount' => [
                'label' => 'Amount',
                'rules' => 'required'
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
        $amount = $this->request->getVar('amount');
        $type = $this->request->getVar('type');

        // validasi balance
        if (!$this->check_balance($type, $amount)) {
            return $this->response->setJSON([
                'code' => 400
            ]);
        }        

        $mdata = [
            'amount' => $amount,
            'type' => $type,
            'member_id' => $member_id,
            'recipient' => $this->request->getVar('recipient'),
            'routing_number' => $this->request->getVar('routing_number'),
            'account_type' => $this->request->getVar('account_type'),
            'swift_code' => $this->request->getVar('swift_code'),
            'wallet_address' => $this->request->getVar('wallet_address'),
            'address' => $this->request->getVar('address'),
            'network' => $this->request->getVar('network'),
        ];

        $url = URL_HEDGEFUND . "/v1/withdraw/request_payment";
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

    private function check_balance($type, $amount) {
        $balance = $this->get_balance();
    
        $availableBalances = [
            'usdt' => $balance['fund']->usdt,
            'usdc' => $balance['fund']->usdt,
            'btc'  => $balance['fund']->btc,
        ];
    
        return isset($availableBalances[$type]) && $amount <= $availableBalances[$type];
    }
    

    public function get_withdraw_history()
    {
        $member_id = $_SESSION["logged_user"]->id;

        $url = URL_HEDGEFUND . "/v1/member/history_payment?id_member=" . $member_id;
        $result = satoshiAdmin($url)->result;

        return $this->response->setJSON([
            'code' => $result->code,
            'message' => $result->message
        ]);
    }

    public function transfer() {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        $balance = $this->get_balance();
        $loggedUser = $session->get('logged_user');
        $mdata = [
            'title' => 'Transfer - ' . NAMETITLE,
            'content' => 'hedgefund/transfer/index',
            'balance' => $balance,
            'extra' => 'hedgefund/transfer/js/_js_index',
            'active_dash' => 'active',
            'refcode'   => $loggedUser->refcode,
            'isreferral'   => $loggedUser->role == 'referral'            
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function transfer_confirm() {
        $member_id  = $_SESSION["logged_user"]->id;
        $from       = $this->request->getVar('from');
        $to         = $this->request->getVar('to');
        $amount     = $this->request->getVar('amount');
        $coin       = $this->request->getVar('coin');
    
        if ($from === 'commission' && $to === 'fund') {
            $url = URL_HEDGEFUND . "/v1/member/transfer_commission";
            $data = ['id_member' => $member_id, 'destination' => 'balance'];
        } elseif (($from === 'fund' && $to === 'trade') || ($from === 'trade' && $to === 'fund')) {
            $url = URL_HEDGEFUND . "/v1/withdraw/transfer_balance";
            $data = ['id_member' => $member_id, 'destination' => $to, 'amount' => $amount, 'coin' => $coin];
        } else {
            session()->setFlashdata('failed', 'Transfer type not supported.');
            return redirect()->to(BASE_URL . 'hedgefund/withdraw/transfer');
        }
    
        $result = satoshiAdmin($url, json_encode($data))->result;
    
        if (!isset($result->code) || $result->code !== 201) {
            session()->setFlashdata('failed', $result->message ?? $result->messages);
            return redirect()->to(BASE_URL . 'hedgefund/withdraw/transfer');
        }
    
        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'hedgefund/withdraw/transfer');
    }

    public function get_balance()
    {
        $member_id = $_SESSION["logged_user"]->id;
        $url = URL_HEDGEFUND . "/v1/member/balance";
    
        $types = ['fund', 'trade', 'commission'];
        $balances = [];
    
        foreach ($types as $type) {
            $response = satoshiAdmin($url, json_encode([
                'id_member' => $member_id,
                'type' => $type
            ]));
    
            $balances[$type] = $response->result->message ?? null;
        }
    
        return $balances;
    }
    
}
