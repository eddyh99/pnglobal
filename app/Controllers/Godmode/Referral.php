<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Referral extends BaseController
{
    protected $validation;

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
    
            if (!in_array('referral', $userAccess)) {
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
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'godmode/referral/index',
            'extra'     => 'godmode/referral/js/_js_index',
            'active_reff'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function createreferral()
    {
        // Validation Field
        $rules = $this->validate([
            'product'     => [
                'label'     => 'Product',
                'rules'     => 'required|in_list[pnglobal, elitebtc, satoshi]'
            ],
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email'
            ],
            'refcode'     => [
                'label'     => 'Referral Code',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('error_validation', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/referral');
        }

        switch ($this->request->getVar('product')) {
            case 'pnglobal':
                $api = URLAPI;
                break;
            case 'elitebtc':
                $api = URL_HEDGEFUND;
                break;
            case 'satoshi':
                $api = URLAPI2;
                break;
        }

        // Init Data
        $mdata = [
            'email'       => htmlspecialchars($this->request->getVar('email')),
            'password'    => sha1('12345678'),
            'role'        => 'referral',
            'status'      => 'active',
            'referral'    => htmlspecialchars($this->request->getVar('upline')),
            'timezone'    => 'Asia/Makassar',
            'ip_address'  => htmlspecialchars($this->request->getIPAddress()),
            'refcode'   => htmlspecialchars($this->request->getVar('refcode'))
        ];


        $url = $api . "/auth/register";
        $result = satoshiAdmin($url, json_encode($mdata, JSON_UNESCAPED_SLASHES))->result;
        // dd($result);

        if($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/referral');
        }

        session()->setFlashdata('success', 'User successfully added.');
        return redirect()->to(BASE_URL . 'godmode/referral');
    }

    public function detailreferral($type, $email)
    {
        // Decode Type
        $finaltype = base64_decode($type);
        $email = base64_decode($email);
        $product = $this->request->getGet('product');

        switch ($product) {
            case 'satoshi-signal':
                $url = URLAPI2 . "/auth/getmember_byemail?email=" . $email;
                break;
            case 'elite':
                $url = URL_HEDGEFUND . "/v1/member/get_detailmember";
                break;
            default:
                $url = URLAPI . "/v1/member/get_detailmember";
                break;
        }


        // Call Get Memeber By Email
        $url = URLAPI . "/v1/member/get_detailmember";
        $resultMember = satoshiAdmin($url, json_encode(['email' => $email]))->result->message;

        // Call Get Detail Referral
        // $url = URLAPI . "/v1/member/detailreferral?id=" . $resultMember->id;
        $resultReferral = [];
        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/referral/detail_referral',
            'extra'     => 'godmode/referral/js/_js_detailreferral',
            'active_reff'  => 'active',
            'member'    => $resultMember,
            'type'      => $finaltype,
            'referral'  => $resultReferral,
            'emailreferral' => $email,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function payreferral($type, $email)
    {
        // Init Data
        $mdata = [
            'id'    => htmlspecialchars($this->request->getVar('id')),
            'type'  => htmlspecialchars($this->request->getVar('type')),
        ];
    }

    public function cancelreferral($email)
    {
        $email  = base64_decode($email);

        // $url = URLAPI . "/v1/referral/cancel_referral?email=".$email;
        // $response = satoshiAdmin($url);
        // $result = $response->result;
        // if($result->code != '200') {
        //     session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
        //     return redirect()->to(BASE_URL . 'godmode/referral/detailreferral/' . base64_encode($email));
        // }else{
        //     session()->setFlashdata('success', "Success Cancelled");
        //     return redirect()->to(BASE_URL . 'godmode/dashboard/detailmember/'.base64_encode('totalmember').'/'. base64_encode($email));
        // }    
    }
}
