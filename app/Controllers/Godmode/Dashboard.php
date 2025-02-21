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

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'admin') {

            header("Location: " . BASE_URL . 'member/auth/pricing');
            exit();
        }
    }

    public function index()
    {
        $url = URLAPI . "/v1/member/get_membership";
        $resultMembership = satoshiAdmin($url)->result;
        $totalmember = $resultMembership->message->total_members ?? 0;
        $totalfreemember = $resultMembership->message->total_free_members ?? 0;
        $totalsubscription = $resultMembership->message->total_subscriptions ?? 0;
        $totalsignal = $resultMembership->message->total_signals ?? 0;

        $mdata = [
            'title'     => 'Dashboard - ' . SATOSHITITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalmember' => $totalmember,
            'freemember' => $totalfreemember,
            'subscriber' => $totalsubscription,
            'signal' => $totalsignal,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function detailmember($email, $id_member)
    {

        // Decode Email
        $finalemail = base64_decode($email);

        // Call Get Memeber By Email
        $url = URLAPI . "/v1/member/get_detailmember";
        $resultMember = satoshiAdmin($url, json_encode(['email' => $finalemail]))->result;

        $mdata = [
            'title'     => 'Detail Member - ' . SATOSHITITLE,
            'content'   => 'godmode/dashboard/detail_member',
            'extra'     => 'godmode/dashboard/js/_js_detailmember',
            'member'    => $resultMember,
            'active_dash'   => 'active',
            'email' => $finalemail,
            'id_member' => $id_member,
            // 'type'      => $finaltype,
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
        $url = URLAPI . "/v1/member/paid_referral?id=" . $mdata['id'] . "&is_paid=" . $mdata['type'];
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;


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

        $url = URLAPI . "/v1/member/destroy";
        $response = satoshiAdmin($url, json_encode(['email' => $email]));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        } else {
            session()->setFlashdata('success', "Success Disabled Member");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }
    }

    public function getlevel_downline($id, $level)
    {
        // Call Endpoin Get Referral Member
        // $url = URLAPI . "/v1/referral/getlevel_downline?id=".$id."&level=".$level;
        // $result = satoshiAdmin($url)->result->message;
        // echo json_encode($result);
    }

    public function set_statusMember($email, $status)
    {
        $url = URLAPI . "/v1/member/set_status";
        $email = base64_decode($email);
        $mdata = [
            'email' => $email,
            'status' => $status
        ];
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        } else {
            session()->setFlashdata('success', "Success Change Status Member");
            return redirect()->to(BASE_URL . 'godmode/dashboard');
        }
    }

    public function get_referralmember()
    {
        $id_member = $this->request->getPost('id_member');
        $url = URLAPI . "/v1/member/list_downline?id_member=" . $id_member;
        $response = satoshiAdmin($url);
        $result = $response->result;
        echo json_encode($result);
    }
}
