<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;

class Withdraw extends BaseController
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
        if ($loggedUser->role !== 'member') {
            header("Location: " . BASE_URL . 'member/auth/login');
            exit();
        }
    }

    public function index()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/index',
            'extra' => 'member/withdraw/js/_js_index',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdt()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/usdt',
            'extra' => 'member/withdraw/js/_js_usdt',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usdc()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/usdc',
            'extra' => 'member/withdraw/js/_js_usdc',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function international_bank()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/international_bank',
            'extra' => 'member/withdraw/js/_js_international_bank',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function usa_bank()
    {
        $mdata = [
            'title' => 'Withdraw - ' . SATOSHITITLE,
            'content' => 'member/withdraw/usa_bank',
            'extra' => 'member/withdraw/js/_js_usa_bank',
            'active_withdraw' => 'active',
        ];

        return view('member/layout/dashboard_wrapper', $mdata);
    }

    public function available_commission()
    {
        $url = URLAPI . "/v1/withdraw/available_commission";
        $result = satoshiAdmin($url)->result->message;

        return $this->response->setJSON([
            'code' => 200,
            'message' => $result
        ]);
    }
}
