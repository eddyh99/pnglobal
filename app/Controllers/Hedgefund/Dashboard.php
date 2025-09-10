<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;

class Dashboard extends BaseController
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
        if (!in_array($loggedUser->role, ['member', 'referral','superadmin'])) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }
    }

    public function index()
    {
        $phone_number = session()->get('logged_user')->phone_number;
        $otp = session()->get('logged_user')->otp;
        // hapus semau sesi
        // dd($_SESSION);
        // session()->remove('logged_user');
        $user = session()->get('logged_user');
        $is_superadmin = $user->role == 'superadmin';
        $wd = new Withdraw;
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'hedgefund/dashboard/index',
            'extra'     => 'hedgefund/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'refcode'   => $_SESSION['logged_user']->refcode,
            'balance'   => $is_superadmin ? $wd->get_totalbalance() : $wd->get_balance(),
            'is_superadmin' => $is_superadmin,
            'isreferral'   => $user->role == 'referral',
            'phone_number' => $phone_number,
            'otp' => $otp
        ];

        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }


    // public function get_trade_history() {
    //     $id_member  = $_SESSION['logged_user']->id;
    //     $url = URL_HEDGEFUND . '/v1/member/history_trade?id_member=' . $id_member;
    //     $result = satoshiAdmin($url);

    //     return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    // }

    public function get_totaltrade_history() {
        $url = URL_HEDGEFUND . "/v1/member/list_transaction?id_member=".ADMIN_ID;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_trade_history(){
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . "/v1/member/list_transaction?id_member=" . $id_member;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function gethistory_withdrawdeposit()
    {
        $id_member = $_SESSION['logged_user']->id;
    
        // Ambil data deposit
        $deposit = [];
        $url_deposit = URL_HEDGEFUND . '/v1/member/history_deposit?id_member=' . urlencode($id_member);
        $response_deposit = satoshiAdmin($url_deposit);
    
        if ($response_deposit && isset($response_deposit->result->message) && is_array($response_deposit->result->message)) {
            $all_deposit = $response_deposit->result->message;
            $deposit = array_filter($all_deposit, function($item) {
                return isset($item->status) && strtolower($item->status) == 'complete';
            });
        }
    
        $withdraw = [];
        $url_withdraw = URL_HEDGEFUND . "/v1/member/history_payment?id_member=" . urlencode($id_member);
        $response_withdraw = satoshiAdmin($url_withdraw);
    
        if (
            $response_withdraw &&
            isset($response_withdraw->result->message) &&
            is_array($response_withdraw->result->message)
        ) {
            $withdraw = $response_withdraw->result->message;
        }
    
        $result = array_merge($deposit, $withdraw);
    
        return $this->response->setJSON([
            'status' => true,
            'message' => $result
        ])->setStatusCode(200);
    }


    // public function get_fundwallet_history(){
    //     $id_member  = $_SESSION['logged_user']->id;
    //     $url = URL_HEDGEFUND . "/v1/member/fundwallet_history?id_member=" . $id_member;
    //     $result = satoshiAdmin($url)->result->message;
    //     echo json_encode($result);
    // }

    // public function history($wallet) {

    //     $mdata = [
    //         'title'     => 'Dashboard - ' . NAMETITLE,
    //         'content'   => 'hedgefund/dashboard/history_fund',
    //         'extra'     => 'hedgefund/dashboard/js/_js_history_fund',
    //         'active_dash'    => 'active',
    //     ];

    //     return view('hedgefund/layout/dashboard_wrapper', $mdata);
    // }

    public function add_whatsapp_number()
    {
        $data = $this->request->getJSON(true);
        $loggedUser = session()->get('logged_user');

        // Validasi nomor WhatsApp
        $this->validation->setRules([
            'phone_number' => 'required|numeric'
        ]);
        if (!$this->validation->run($data)) {
            return $this->response
                ->setStatusCode(422) // Unprocessable Entity
                ->setJSON([
                    'success' => false,
                    'message' => $this->validation->getErrors()
                ]);
        }

        $phone_number = $data['phone_number'] ?? null;
        $email        = session()->get('logged_user')->email;

        $url = URL_HEDGEFUND . '/v1/member/add_phone_number';
        $payload = [
            'email'        => $email,
            'phone_number' => $phone_number
        ];
        $response = satoshiAdmin($url, json_encode($payload));
        $result   = $response->result ?? null;

        
        if ($result->status == 201) {
            $loggedUser->phone_number = $phone_number;
            $loggedUser->otp = $result->otp;
            session()->set('logged_user', $loggedUser);
            // Berhasil menambahkan nomor WhatsApp dan mengirim OTP
            
            return $this->response->setJSON([
                'success' => true,
                'otp'     => $result->otp
            ]);
        }

        return $this->response
            ->setStatusCode(400) // Bad Request
            ->setJSON([
                'success' => false,
                'message' => 'Failed to resend activation code.'
            ]);
    }

    public function verif_otp()
    {
        $loggedUser = session()->get('logged_user');
        // Pastikan method POST
        if (!$this->request->is('post')) {
            return $this->response->setJSON([
                'code' => 400,
                'success' => false,
                'message' => 'Invalid request method'
            ]);
        }

        try {
            // Ambil data dari POST (fetch)
            $email = $this->request->getPost('email');
            $otp   = $this->request->getPost('otp');

            if (empty($email) || empty($otp)) {
                return $this->response->setJSON([
                    'code' => 400,
                    'success' => false,
                    'message' => 'Email and OTP are required'
                ]);
            }

            // Siapkan data untuk dikirim ke API
            $mdata = [
                'email' => $email,
                'otp'   => $otp
            ];

            // Panggil endpoint activate member
            $url = URL_HEDGEFUND . "/auth/activate_member";

            // satoshiAdmin() = helper untuk call API
            $response = satoshiAdmin($url, json_encode($mdata));

            // Ambil code & message dari response API
            $code = $response->result->code ?? 400;
            $message = $response->result->message ?? 'Failed to process request';
            if ($code == 200) {
                $loggedUser->otp = null;
                session()->set('logged_user', $loggedUser);
            }

            return $this->response->setJSON([
                'code' => $code,
                'success' => ($code == 200), // success jika code 200
                'message' => $message
            ]);
        } catch (\Exception $e) {
            // Log error untuk debug
            log_message('error', 'OTP Processing Error: ' . $e->getMessage());

            return $this->response->setJSON([
                'code' => 500,
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ]);
        }
    }
}
