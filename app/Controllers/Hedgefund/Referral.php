<?php

namespace App\Controllers\Hedgefund;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class Referral extends BaseController
{

    public function __construct()
    {
        // throw PageNotFoundException::forPageNotFound();
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya member yang boleh mengakses halaman ini
        if (!in_array($loggedUser->role, ['member', 'referral','superadmin'])) {
            header("Location: " . BASE_URL . 'hedgefund/auth/login');
            exit();
        }

        if ($loggedUser->role != 'referral' && $loggedUser->role != 'superadmin') {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function index()
    {
        $user = session()->get('logged_user');
        $is_superadmin = $user->role == 'superadmin';
        $mdata = [
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'hedgefund/referral/index',
            'extra'     => 'hedgefund/referral/js/_js_index',
            'is_superadmin' => $is_superadmin,
            'active_referral'    => 'active',
            'refcode'   => $_SESSION['logged_user']->refcode,
        ];
        return view('hedgefund/layout/dashboard_wrapper', $mdata);
    }

    public function get_summary()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url        =  URL_HEDGEFUND . '/v1/member/referral_summary?id_member='. $id_member;
        $result     = satoshiAdmin($url);
        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_summarymaster()
    {
        $url        =  URL_HEDGEFUND . '/v1/member/referral_mastersummary';
        $result     = satoshiAdmin($url);
        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_referral()
    {
        $id_member  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . '/v1/member/list_downline?id_member=' . $id_member;
        $result = satoshiAdmin($url);

        return $this->response->setJSON(['status' => true, 'message' => $result->result->message])->setStatusCode(200);
    }

    public function get_comission(){
        $id  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . "/v1/member/list_comission2?id_member=" . $id;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_comissionmaster(){
        $url = URL_HEDGEFUND . "/v1/member/list_mastercomission";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_downline()
    {
        $id  = $_SESSION['logged_user']->id;
        $url = URL_HEDGEFUND . "/v1/member/list_downline?id_member=" . $id;
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function get_downlinemaster()
    {

        $url = URL_HEDGEFUND . "/v1/member/list_masterdownline";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }
}
