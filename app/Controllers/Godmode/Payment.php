<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    public function __construct()
    {
        // $session = session();
        // if(!$session->has('logged_user')){
        //     header("Location: ". BASE_URL . 'godmode/auth/signin');
        //     exit();
        // }
        // if ($_SESSION["logged_user"]->role!='admin'){
        //     header('HTTP/1.0 403 Forbidden');
        //     exit();
        // }

    }

    public function index()
    {
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/index',
            'extra'     => 'godmode/payment/js/_js_index',
            'active_payment'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_requestpayment()
    {
        // Call Endpoin Get Total Member
        $url = URLAPI . "/v1/withdraw/request_payment";
        $response = satoshiAdmin($url);
        $result = $response->result;

        $data = [
            'code' => $result->code,
            'message' => $result->message
        ];
        return json_encode($data);
    }

    public function detailpayment($id, $email)
    {
        $email = base64_decode($email);

        // Call Get Detail Request
        $url = URLAPI . "/v1/withdraw/detail_request_payment?id=" . $id;
        $resultPayment = satoshiAdmin($url)->result->message;
        $mdata = [
            'title'     => 'Detail Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/detail_payment',
            'extra'     => 'godmode/payment/js/_js_detailpayment',
            'active_payment'  => 'active',
            'payment'    => $resultPayment,
            'email'    => $email,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function payment_process()
    {
        // Init Data
        $mdata = [
            'member_id'    => htmlspecialchars($this->request->getVar('member_id')),
            'reqid'  => htmlspecialchars($this->request->getVar('reqid')),
        ];
    }

    public function sendbonus()
    {
        // Init Data
        $mdata = [
            'email'    => htmlspecialchars($this->request->getVar('email')),
            'amount'  => htmlspecialchars($this->request->getVar('amount')),
        ];
    }
}
