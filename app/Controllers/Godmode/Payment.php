<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    public function __construct()
    {
        $session = session();
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    
        $loggedUser = $session->get('logged_user');
    
        // If role is superadmin, allow full access
        if ($loggedUser->role === 'superadmin') {
            return;
        }
    
        // If role is admin, check access
        if ($loggedUser->role === 'admin') {
            $userAccess = json_decode($loggedUser->access, true);
            if (!is_array($userAccess)) {
                $userAccess = [];
            }
    
            if (!in_array('payment', $userAccess)) {
                session()->setFlashdata('failed', 'You don\'t have access to this page');
                header("Location: " . BASE_URL . 'godmode/dashboard');
                exit();
            }
    
            return;
        }
    
        // For other roles, deny access
        session()->setFlashdata('failed', 'You don\'t have access to this page');
        header("Location: " . BASE_URL . 'godmode/dashboard');
        exit();
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

    public function detailpayment($id, $email, $amount, $requested_at = null)
    {
        $email = base64_decode($email);
        $amount = base64_decode($amount);
        $requested_at = $requested_at ? base64_decode($requested_at) : null;
        $url = URLAPI . "/v1/withdraw/detail_request_payment?id=" . $id;
        $resultPayment = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Detail Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/detail_payment',
            'extra'     => 'godmode/payment/js/_js_detailpayment',
            'active_payment'  => 'active',
            'payment'    => $resultPayment,
            'id'    => $id,
            'email'    => $email,
            'amount'    => $amount,
            'requested_at' => $requested_at,
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

        $url = URLAPI2 . "/v1/payment/send_bonus";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            if ($_GET["type"] == "free") {
                return redirect()->to(BASE_URL . 'godmode/freemember/detailmember/' . base64_encode($mdata["email"]));
            } elseif ($_GET["type"] == "ref") {
                return redirect()->to(BASE_URL . 'godmode/referral/detailmember/' . base64_encode($mdata["email"]));
            } else {
                return redirect()->to(BASE_URL . 'godmode/dashboard/detailmember/' . base64_encode("totalmember") . '/' . base64_encode($mdata["email"]));
            }
        } else {
            session()->setFlashdata('success', "Bonus has been successfully sent");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }
    }

    public function get_satoshi_requestpayment()
    {
        // Call Endpoint Get Satoshi Request Payment
        $url = URLAPI2 . "/v1/payment/requestpayment";
        $response = satoshiAdmin($url);
        $result = $response->result;

        $data = [
            'code' => $result->code,
            'message' => $result->message
        ];
        return json_encode($data);
    }
}
