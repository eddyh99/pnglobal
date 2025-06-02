<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        $urlglobal = URLAPI . "/v1/member/get_membership";
        $resultglobal = satoshiAdmin($urlglobal)->result;

        $urlelite = URL_HEDGEFUND . "/v1/member/get_statistics";
        $resultElite = satoshiAdmin($urlelite)->result;

        // Call Endpoin total_member
        $url = URLAPI2 . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result;

        // Call Endpoin total free member
        $url = URLAPI2 . "/v1/member/total_freemember";
        $resultFreemember = satoshiAdmin($url)->result;

        // Call Endpoin total Referral
        $url = URLAPI2 . "/v1/subscription/subscribe_active";
        $resultSubscriber = satoshiAdmin($url)->result;

        // Call Endpoin total Message
        $url = URLAPI2 . "/v1/signal/total_message";
        $resultMessage = satoshiAdmin($url)->result;

        // Call Endpoin total Signal
        $url = URLAPI2 . "/v1/member/total_signal";
        $resultSignal = satoshiAdmin($url)->result;


        // PN Global
        $totalmemberpnglobal = $resultglobal->message->total_members ?? 0;
        $totalfreememberpnglobal = $resultglobal->message->total_free_members ?? 0;
        $totalsubscriptionpnglobal = $resultglobal->message->total_subscriptions ?? 0;
        $totalsignalpnglobal = $resultglobal->message->total_signals ?? 0;

        // ELITE
        $totalmemberelite = $resultElite->message->members ?? 0;
        $subscriberelite = $resultElite->message->active_members ?? 0;
        $referralelite = $resultElite->message->referrals ?? 0;
        $signalelite = $resultElite->message->signals ?? 0;

        // Satoshi Signal
        $totalmembersatoshi = $resultTotalMember->message ?? 0;
        $totalfreemembersatoshi = $resultFreemember->message ?? 0;
        $totalsubscriptionsatoshi = $resultSubscriber->message ?? 0;
        $totalsignalsatoshi = $resultSignal->message ?? 0;
        $totalmessagesatoshi = $resultMessage->message ?? 0;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'totalmemberpnglobal' => $totalmemberpnglobal,
            'freememberpnglobal' => $totalfreememberpnglobal,
            'subscriberpnglobal' => $totalsubscriptionpnglobal,
            'signalpnglobal' => $totalsignalpnglobal,
            'totalmembersatoshi' => $totalmembersatoshi,
            'freemembersatoshi' => $totalfreemembersatoshi,
            'subscriptionsatoshi' => $totalsubscriptionsatoshi,
            'signalsatoshi' => $totalsignalsatoshi,
            'messagesatoshi' => $totalmessagesatoshi,
            'totalmemberelite' => $totalmemberelite,
            'subscriberelite' => $subscriberelite,
            'referralelite' => $referralelite,
            'signalelite' => $signalelite 

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    // public function detailmember($email, $id_member)
    // {

    //     $urlelite = URL_HEDGEFUND . "/v1/member/get_statistics";
    //     $resultElite = satoshiAdmin($urlelite)->result;

    //     // ELITE
    //     $totalmemberelite = $resultElite->message->members ?? 0;
    //     $subscriberelite = $resultElite->message->active_members ?? 0;
    //     $referralelite = $resultElite->message->referrals ?? 0;
    //     $signalelite = $resultElite->message->signals ?? 0;

    //     $mdata = [
    //         'title'     => 'Dashboard - ' . NAMETITLE,
    //         'content'   => 'godmode/dashboard/hedgefund',
    //         'extra'     => 'godmode/dashboard/js/_js_hedgefund',
    //         'sidebar'   => 'hedgefund_sidebar',
    //         'navbar_hedgefund' => 'active',
    //         'active_dash'    => 'active',
    //         'totalmemberelite' => $totalmemberelite,
    //         'subscriberelite' => $subscriberelite,
    //         'referralelite' => $referralelite,
    //         'signalelite' => $signalelite 

    //     ];

    //     return view('godmode/layout/admin_wrapper', $mdata);
    // }

    public function satoshi()
    {
        // Call Endpoin total_member
        $url = URLAPI2 . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result;

        // Call Endpoin total free member
        $url = URLAPI2 . "/v1/member/total_freemember";
        $resultFreemember = satoshiAdmin($url)->result;

        // Call Endpoin total Referral
        $url = URLAPI2 . "/v1/subscription/subscribe_active";
        $resultSubscriber = satoshiAdmin($url)->result;

        // Call Endpoin total Message
        $url = URLAPI2 . "/v1/signal/total_message";
        $resultMessage = satoshiAdmin($url)->result;

        // Call Endpoin total Signal
        $url = URLAPI2 . "/v1/member/total_signal";
        $resultSignal = satoshiAdmin($url)->result;

        // Satoshi Signal
        $totalmembersatoshi = $resultTotalMember->message ?? 0;
        $totalfreemembersatoshi = $resultFreemember->message ?? 0;
        $totalsubscriptionsatoshi = $resultSubscriber->message ?? 0;
        $totalsignalsatoshi = $resultSignal->message ?? 0;
        $totalmessagesatoshi = $resultMessage->message ?? 0;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/satoshi',
            'extra'     => 'godmode/dashboard/js/_js_satoshi',
            'sidebar'   => 'satoshi_sidebar',
            'navbar_satoshi' => 'active',
            'active_dash'    => 'active',
            'totalmembersatoshi' => $totalmembersatoshi,
            'freemembersatoshi' => $totalfreemembersatoshi,
            'subscriptionsatoshi' => $totalsubscriptionsatoshi,
            'signalsatoshi' => $totalsignalsatoshi,
            'messagesatoshi' => $totalmessagesatoshi

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function luxbtc()
    {
        $urlglobal = URLAPI . "/v1/member/get_membership";
        $resultglobal = satoshiAdmin($urlglobal)->result;

        // PN Global
        $totalmemberpnglobal = $resultglobal->message->total_members ?? 0;
        $totalfreememberpnglobal = $resultglobal->message->total_free_members ?? 0;
        $totalsubscriptionpnglobal = $resultglobal->message->total_subscriptions ?? 0;
        $totalsignalpnglobal = $resultglobal->message->total_signals ?? 0;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/luxbtc',
            'extra'     => 'godmode/dashboard/js/_js_luxbtc',
            'sidebar'   => 'luxbtc_sidebar',
            'navbar_luxbtc' => 'active',
            'active_dash'    => 'active',
            'totalmemberpnglobal' => $totalmemberpnglobal,
            'freememberpnglobal' => $totalfreememberpnglobal,
            'subscriberpnglobal' => $totalsubscriptionpnglobal,
            'signalpnglobal' => $totalsignalpnglobal,

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function hedgefund()
    {
        $urlglobal = URL_HEDGEFUND . "/v1/member/get_statistics";
        $resultElite = satoshiAdmin($urlglobal)->result;

        // PN Global
        // ELITE
        $totalmemberelite = $resultElite->message->members ?? 0;
        $subscriberelite = $resultElite->message->active_members ?? 0;
        $referralelite = $resultElite->message->referrals ?? 0;
        $signalelite = $resultElite->message->signals ?? 0;

        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/hedgefund',
            'extra'     => 'godmode/dashboard/js/_js_hedgefund',
            'sidebar'   => 'hedgefund_sidebar',
            'navbar_hedgefund' => 'active',
            'active_dash'    => 'active',
            'totalmemberelite' => $totalmemberelite,
            'subscriberelite' => $subscriberelite,
            'referralelite' => $referralelite,
            'signalelite' => $signalelite 

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function detailmember($type, $email, $id_member)
    {
        // Decode Email
        $finalemail = base64_decode($email);

        // Log untuk debugging
        log_message('debug', 'Detail member - Raw tab parameter: ' . $this->request->getGet('tab'));
        log_message('debug', 'Detail member - Email: ' . $finalemail);

        // Determine which API endpoint to use based on active tab
        // $url = $tab === 'satoshi-signal'
        //     ? URLAPI2 . "/auth/getmember_byemail?email=" . $finalemail
        //     : URLAPI . "/v1/member/get_detailmember";

        switch ($type) {
            case 'satoshi':
                $url = URLAPI2 . "/auth/getmember_byemail?email=" . $finalemail;
                break;
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/get_detailmember";
                break;
            default:
                $url = URLAPI . "/v1/member/get_detailmember";
                break;
        }

        log_message('debug', 'Detail member - Using API URL: ' . $url);

        // $resultMember = $tab === 'satoshi-signal'
        //     ? satoshiAdmin($url)->result
        //     : satoshiAdmin($url, json_encode(['email' => $finalemail]))->result;

        switch ($type) {
            case 'satoshi':
                $resultMember = satoshiAdmin($url)->result;
                break;
            case 'hedgefund':
                $resultMember = satoshiAdmin($url, json_encode(['email' => $finalemail]))->result;
                break;
            default:
                $resultMember = satoshiAdmin($url, json_encode(['email' => $finalemail]))->result;
                break;
        }

        log_message('debug', 'Detail member - API Response received');

        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/detailmember_' . $type,
            'extra'     => 'godmode/dashboard/js/_js_detailmember',
            'member'    => $resultMember->message,
            'sidebar'   => $type . '_sidebar',
            'navbar_' . $type => 'active',
            'active_dash'   => 'active',
            'email' => $finalemail,
            'id_member' => $id_member,
            'type'      => $type
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
            'title'     => 'Detail Member - ' . NAMETITLE,
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

    public function deletemember($type, $email)
    {
        $email  = base64_decode($email);

        switch ($type) {
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/destroy";
                break;
            case 'satoshi':
                $url = URLAPI2 . "/v1/member/destroy";
                break;
            default:
                $url = URLAPI . "/v1/member/destroy";
                break;
        }

        // $url = URLAPI . "/v1/member/destroy";
        $response = satoshiAdmin($url, json_encode(['email' => $email]));
        $result = $response->result;

        if (($result->code ?? $response->status) != '201') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard/' . $type);
        } else {
            session()->setFlashdata('success', "Success Disabled Member");
            return redirect()->to(BASE_URL . 'godmode/dashboard/' . $type);
        }
    }

    public function get_downline($type, $id)
    {
        
        switch ($type) {
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/list_downline?id_member=" . $id;
                break;
            case 'satoshi':
                $url = URLAPI2 . "/v1/member/listdownline";
                break;
            default:
                $url = URLAPI . "/v1/member/list_downline?id_member=" . $id;
                break;
        }
        
        // $url = URLAPI2 . "/v1/referral/getDownline?id=" . $id;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function getlevel_downline($id, $level)
    {
        // Call Endpoin Get Referral Member
        $url = URLAPI2 . "/v1/referral/getlevel_downline?id=" . $id . "&level=" . $level;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    

    public function set_statusMember($type, $email, $status)
    {
        $email = base64_decode($email);
        switch ($type) {
            case 'hedgefund':
                $url = URL_HEDGEFUND . "/v1/member/set_status";
                break;
            case 'satoshi':
                $url = URLAPI2 . "/v1/member/" .($status == 'disabled' ? 'disable' : 'enable'). "_member?email=".$email;
                break;
            default:
                $url = URLAPI . "/v1/member/set_status";
                break;
        }
        // $url = URLAPI . "/v1/member/set_status";
        $mdata = [
            'email' => $email,
            'status' => $status
        ];
        $response = satoshiAdmin($url, $type === 'satoshi' ? null : json_encode($mdata));
        $result = $response->result;

        if (($result->code ?? $response->status) != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/dashboard/' . $type);
        } else {
            session()->setFlashdata('success', "Success Change Status Member");
            return redirect()->to(BASE_URL . 'godmode/dashboard/' . $type);
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
