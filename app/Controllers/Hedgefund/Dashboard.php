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

        $user = session()->get('logged_user');
        $is_superadmin = $user->role == 'superadmin';
        // dd($user->role);
        $wd = new Withdraw;
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'hedgefund/dashboard/index',
            'extra'     => 'hedgefund/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'refcode'   => $_SESSION['logged_user']->refcode,
            'balance'   => $is_superadmin ? $wd->get_totalbalance() : $wd->get_balance(),
            'is_superadmin' => $is_superadmin,
            'isreferral'   => $user->role == 'referral'
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
}
