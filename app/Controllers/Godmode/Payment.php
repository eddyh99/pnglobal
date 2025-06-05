<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Payment extends BaseController
{
    // public function __construct()
    // {
    //     $session = session();
    //     if (!$session->has('logged_user')) {
    //         header("Location: " . BASE_URL . 'godmode/auth/signin');
    //         exit();
    //     }
    
    //     $loggedUser = $session->get('logged_user');
    
    //     // If role is superadmin, allow full access
    //     if ($loggedUser->role === 'superadmin') {
    //         return;
    //     }
    
    //     // If role is admin, check access
    //     if ($loggedUser->role === 'admin') {
    //         $userAccess = json_decode($loggedUser->access, true);
    //         if (!is_array($userAccess)) {
    //             $userAccess = [];
    //         }
    
    //         if (!in_array('payment', $userAccess)) {
    //             session()->setFlashdata('failed', 'You don\'t have access to this page');
    //             header("Location: " . BASE_URL . 'godmode/dashboard');
    //             exit();
    //         }
    
    //         return;
    //     }
    
    //     // For other roles, deny access
    //     session()->setFlashdata('failed', 'You don\'t have access to this page');
    //     header("Location: " . BASE_URL . 'godmode/dashboard');
    //     exit();
    // }


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

    public function hedgefund()
    {
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/hedgefund',
            'extra'     => 'godmode/payment/js/_js_hedgefund',
            'active_payment'    => 'active active-menu',
            'sidebar'   => 'hedgefund_sidebar',
            'navbar_hedgefund' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function satoshi()
    {
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/satoshi',
            'extra'     => 'godmode/payment/js/_js_satoshi',
            'active_payment'    => 'active active-menu',
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active'
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

    public function detailpayment($type, $id)
    {
        switch ($type) {
            case 'hedgefund':
                $endpoint = URL_HEDGEFUND;
                break;
            default:
                $endpoint = URLAPI;
                break;
        }

        $url = $endpoint . "/v1/withdraw/detail_request_payment?id=" . $id;
        $resultPayment = satoshiAdmin($url)->result->message;
        $mdata = [
            'title'     => 'Detail Payment - ' . NAMETITLE,
            'content'   => 'godmode/payment/detail_payment',
            'extra'     => 'godmode/payment/js/_js_detailpayment',
            'sidebar'   => $type . '_sidebar',
            'navbar_' . $type => 'active',
            'active_payment'  => 'active',
            'payment'    => $resultPayment,
            'id'         => $id,
            'type'       => $type
        ];

        if (empty($resultPayment)) {
            throw PageNotFoundException::forPageNotFound();
        }        

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function payment_process()
    {
        // Init Data
        $mdata = [
            'email'     => htmlspecialchars($this->request->getPost('email')),
            'reqid'     => htmlspecialchars($this->request->getPost('reqid')),
            'status'    => 'completed'
        ];
        
        $url = URL_HEDGEFUND . "/v1/withdraw/update_status";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        if ($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/payment/detailpayment/hedgefund/'.$mdata["reqid"]);
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/payment/hedgefund');
        }
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

    public function get_elitebtc_requestpayment()
    {
        // Call Endpoint Get Satoshi Request Payment
        $url = URL_HEDGEFUND . "/v1/withdraw/request_payment";
        $response = satoshiAdmin($url);
        $result = $response->result;

        $data = [
            'code' => $result->code,
            'message' => $result->message
        ];
        return json_encode($data);
    }
}
