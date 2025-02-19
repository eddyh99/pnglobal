<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');
        // echo "<pre>";
        // print_r($loggedUser->token);
        // echo "</pre>";
        // die();

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'admin') {

            header("Location: " . BASE_URL . 'member/auth/pricing');
            exit();
        }
    }

    public function index()
    {
        /* Temporarily disabled API calls for layout development
        // Call Endpoin total_member
        $url = URLAPI . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result->message;

        // Call Endpoin total free member
        $url = URLAPI . "/v1/member/total_freemember";
        $resultFreemember = satoshiAdmin($url)->result->message;

        // Call Endpoin total Referral
        $url = URLAPI . "/v1/member/total_exclusive";
        $resultReferral = satoshiAdmin($url)->result->message;

        // Call Endpoin total Message
        $url = URLAPI . "/v1/signal/total_message";
        $resultMessage = satoshiAdmin($url)->result->message;

        // Call Endpoin total Signal
        $url = URLAPI . "/v1/member/total_signal";
        $resultSignal = satoshiAdmin($url)->result->message;
        */

        // Temporary dummy data for layout development
        $resultTotalMember = 100;
        $resultFreemember = 50;
        $resultReferral = 25;
        $resultMessage = 75;
        $resultSignal = 30;
        $resultSubscriber = 100;

        $mdata = [
            'title'     => 'Dashboard - ' . SATOSHITITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalmember' => $resultTotalMember,
            'freemember' => $resultFreemember,
            'referral' => $resultReferral,
            'message' => $resultMessage,
            'signal' => $resultSignal,
            'subscriber' => $resultSubscriber,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function detailmember($type, $email)
    {

        // Decode Type
        $finaltype = base64_decode($type);

        // Call Get Memeber By Email
        // $url = URLAPI . "/auth/getmember_byemail?email=".base64_decode($email);
        // $resultMember = satoshiAdmin($url)->result->message;

        // echo '<pre>'.print_r($resultMember,true).'</pre>';
        // die;

        $resultMember = null;
        $mdata = [
            'title'     => 'Detail Member - ' . SATOSHITITLE,
            'content'   => 'godmode/dashboard/detail_member',
            'extra'     => 'godmode/dashboard/js/_js_detailmember',
            'member'    => $resultMember,
            'active_dash'   => 'active',
            'type'      => $finaltype,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }


    public function detailreferral($type, $email)
    {

        // Decode Type
        $finaltype = base64_decode($type);

        // Call Get Memeber By Email
        // $url = URLAPI . "/auth/getmember_byemail?email=".base64_decode($email);
        // $resultMember = satoshiAdmin($url)->result->message;

        // Call Get Detail Referral
        // $url = URLAPI . "/v1/member/detailreferral?id=".$resultMember->id;
        // $resultReferral = satoshiAdmin($url)->result->message;

        $resultMember = null;
        $resultReferral = null;

        $mdata = [
            'title'     => 'Detail Member - ' . SATOSHITITLE,
            'content'   => 'godmode/dashboard/detail_referral',
            'extra'     => 'godmode/dashboard/js/_js_detailreferral',
            'active_dash'  => 'active',
            'member'    => $resultMember,
            'type'      => $finaltype,
            'emailreferral' => base64_decode($email),
            'referral'  => $resultReferral
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

        // Proccess Endpoin API
        // $url = URLAPI . "/v1/member/paid_referral?id=".$mdata['id']."&is_paid=".$mdata['type'];
        // $response = satoshiAdmin($url, json_encode($mdata));
        // $result = $response->result;

        $result = null;

        if ($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard/detailreferral/' . $type . '/' . $email);
        } else {

            if ($mdata['type'] == 'yes') {
                session()->setFlashdata('success', "Successfully paid transaction");
            } else {
                session()->setFlashdata('success', "Successfully cancel transaction");
            }
            return redirect()->to(BASE_URL . 'godmode/dashboard/detailreferral/' . $type . '/' . $email);
        }
    }

    public function deletemember($email)
    {
        $email  = base64_decode($email);

        // $url = URLAPI . "/v1/member/delete_member?email=".$email;
        // $response = satoshiAdmin($url);
        // $result = $response->result;

        $result = null;

        if ($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        } else {
            session()->setFlashdata('success', "Success Disabled Member");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }
    }

    public function get_downline($id)
    {
        // Call Endpoin Get Referral Member
        // $url = URLAPI . "/v1/referral/getDownline?id=".$id;
        // $result = satoshiAdmin($url)->result->message;
        // echo json_encode($result);
    }

    public function getlevel_downline($id, $level)
    {
        // Call Endpoin Get Referral Member
        // $url = URLAPI . "/v1/referral/getlevel_downline?id=".$id."&level=".$level;
        // $result = satoshiAdmin($url)->result->message;
        // echo json_encode($result);
    }
}
