<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Referral extends BaseController
{
    protected $validation;

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
    
    //         if (!in_array('referral', $userAccess)) {
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
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'godmode/referral/index',
            'extra'     => 'godmode/referral/js/_js_index',
            'active_reff'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function hedgefund()
    {
        check_access();
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/referral/hedgefund',
            'extra'     => 'godmode/referral/js/_js_hedgefund',
            'active_reff'    => 'active active-menu',
            'sidebar'   => 'hedgefund_sidebar',
            'navbar_hedgefund' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function luxbtc()
    {
        check_access();
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/referral/luxbtc',
            'extra'     => 'godmode/referral/js/_js_luxbtc',
            'active_reff'    => 'active active-menu',
            'sidebar'   => 'luxbtc_sidebar',
            'navbar_luxbtc' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function satoshi()
    {
        check_access();
        $mdata = [
            'title'     => 'Payment - ' . NAMETITLE,
            'content'   => 'godmode/referral/satoshi',
            'extra'     => 'godmode/referral/js/_js_satoshi',
            'active_reff'    => 'active active-menu',
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function createreferral()
    {
        // Validation Field
        $rules = $this->validate([
            'product'     => [
                'label'     => 'Product',
                'rules'     => 'required|in_list[luxbtc, hedgefund, satoshi]'
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

        $type = $this->request->getVar('product');
        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/referral/' . $type);
        }

        switch ($type) {
            case 'luxbtc':
                $url = URLAPI . "/auth/register";
                break;
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/auth/register";
                break;
            case 'satoshi':
                $url = URLAPI2 . "/v1/member/create_referral";
                break;
        }

        // Init Data
        $mdata = [
            'email'       => htmlspecialchars($this->request->getVar('email')),
            'password'    => sha1('12345678'),
            'role'        => 'referral',
            'status'      => 'active',
            'referral'    => htmlspecialchars($this->request->getVar('upline')),
            'upline'    => htmlspecialchars($this->request->getVar('upline')),
            'timezone'    => 'Asia/Makassar',
            'ip_address'  => htmlspecialchars($this->request->getIPAddress()),
            'ipaddress'  => htmlspecialchars($this->request->getIPAddress()),
            'refcode'   => htmlspecialchars($this->request->getVar('refcode'))
        ];


        $result = satoshiAdmin($url, json_encode($mdata, JSON_UNESCAPED_SLASHES))->result;
        // dd($result);

        if($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/referral/' . $type);
        }

        $subject = "Activation Account - HEDGE FUND";
        sendmail_satoshi($mdata['email'], $subject,  emailtemplate_activation_account($result->message->otp, $mdata['email'],"HEDGE FUND", 'hedgefund/auth/forgot_pass_otp/'),"HEDGE FUND",USERNAME_MAIL);
        session()->setFlashdata('success', 'User successfully added.');
        return redirect()->to(BASE_URL . 'godmode/referral/' . $type );
    }

    public function detail($type, $email)
    {
        // Decode Type
        $finaltype = base64_decode($type);
        $email = base64_decode($email);

        switch ($type) {
            case 'satoshi':
                $url = URLAPI2 . "/auth/getmember_byemail?email=" . $email;
                break;
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/get_detailmember";
                break;
            default:
                $url = URLAPI . "/v1/member/get_detailmember";
                break;
        }

        $resultMember = satoshiAdmin($url, json_encode(['email' => $email]))->result->message;
        $resultReferral = [];
        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/referral/detail_referral',
            'extra'     => 'godmode/referral/js/_js_detailreferral',
            'active_reff'  => 'active',
            'sidebar'   => $type . '_sidebar',
            'navbar_hedgefund' => 'active',
            'member'    => $resultMember,
            'referral'  => $resultReferral,
            'emailreferral' => $email,
            'type'      => $type
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

    public function update_refcode()
    {
        // Validation Field
        $rules = $this->validate([
            'idmember'     => [
                'label'     => 'ID Member',
                'rules'     => 'required'
            ],
            'refcode'     => [
                'label'     => 'Referral Code',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/referral/detail/hedgefund/' . base64_encode($this->request->getVar('email')));
        }

        // Init Data
        $mdata = [
            'idmember' => $this->request->getVar('idmember'),
            'refcode' => $this->request->getVar('refcode')
        ];

        $url = URL_HEDGEFUND . "/v1/member/update_refcode";
        $result = satoshiAdmin($url, json_encode($mdata, JSON_UNESCAPED_SLASHES))->result;

        if($result->code != 200) {
            session()->setFlashdata('failed', $result->message);
        } else {
            session()->setFlashdata('success', $result->message);
        }

        return redirect()->to(BASE_URL . 'godmode/referral/detail/hedgefund/' . base64_encode($this->request->getVar('email')));
    }

}
