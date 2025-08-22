<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Bank_account extends BaseController
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
        $urlBankUS = URL_HEDGEFUND . "/non/us-bank";
        $resultBankUS = satoshiAdmin($urlBankUS);

        $urlBankInter = URL_HEDGEFUND . "/non/international-bank";
        $resultBankInter = satoshiAdmin($urlBankInter);

        $mdata = [
            'title'     => 'Bank Account - ' . NAMETITLE,
            'content'   => 'godmode/bank_account/index',
            'active_bank_account'    => 'active active-menu',
            'sidebar'        => 'console_sidebar',
            'navbar_console' => 'active',
            'us_bank' => $resultBankUS->result,
            'international_bank' => $resultBankInter->result
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function addbankus()
    {
        $us_bank_account_name = $this->request->getVar('us_bank_account_name');
        $us_bank_account_type = $this->request->getVar('us_bank_account_type');
        $us_bank_routing_number = $this->request->getVar('us_bank_routing_number');
        $us_bank_account_number = $this->request->getVar('us_bank_account_number');
        $us_bank_fee_setting = $this->request->getVar('us_bank_fee_setting');

        if (!$this->validate([
            'us_bank_account_name' => 'required',
            'us_bank_account_type' => 'required|in_list[checking,saving]',
            'us_bank_routing_number' => 'required',
            'us_bank_account_number' => 'required',
            'us_bank_fee_setting' => 'required',
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        }

        $mdata = [
            'us_bank_account_name' => $us_bank_account_name,
            'us_bank_account_type' => $us_bank_account_type,
            'us_bank_routing_number' => $us_bank_routing_number,
            'us_bank_account_number' => $us_bank_account_number,
            'us_bank_fee_setting' => $us_bank_fee_setting,
        ];

        $url = URL_HEDGEFUND . "/non/us-bank";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 201) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'Bank account successfully added.');
        } else {
            $error = $result->messages->email ?? 'Failed to add bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

    public function updatebankus()
    {
        $us_bank_account_name = $this->request->getVar('us_bank_account_name');
        $us_bank_account_type = $this->request->getVar('us_bank_account_type');
        $us_bank_routing_number = $this->request->getVar('us_bank_routing_number');
        $us_bank_account_number = $this->request->getVar('us_bank_account_number');
        $us_bank_fee_setting = $this->request->getVar('us_bank_fee_setting');

        if (!$this->validate([
            'us_bank_account_name' => 'required',
            'us_bank_account_type' => 'required|in_list[checking,saving]',
            'us_bank_routing_number' => 'required',
            'us_bank_account_number' => 'required',
            'us_bank_fee_setting' => 'required',
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        }

        $mdata = [
            'us_bank_account_name' => $us_bank_account_name,
            'us_bank_account_type' => $us_bank_account_type,
            'us_bank_routing_number' => $us_bank_routing_number,
            'us_bank_account_number' => $us_bank_account_number,
            'us_bank_fee_setting' => $us_bank_fee_setting,
        ];

        $url = URL_HEDGEFUND . "/non/us-bank-update";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 200) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'Bank account successfully updated.');
        } else {
            $error = $result->messages->email ?? 'Failed to update bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

    public function addbankinter()
    {
        $inter_bank_account_name = $this->request->getVar('inter_bank_account_name');
        $inter_bank_account_number = $this->request->getVar('inter_bank_account_number');
        $inter_bank_swift_code = $this->request->getVar('inter_swift_code');
        $inter_bank_fee_setting = $this->request->getVar('inter_fee_setting');
        $inter_bank_routing_number = $this->request->getVar('inter_bank_routing_number');
        $inter_bank_company_address = $this->request->getVar('inter_bank_company_address');

        if (!$this->validate([
            'inter_bank_account_name'   => 'required',
            'inter_bank_account_number' => 'required|numeric',
            'inter_swift_code'          => 'required|alpha_numeric_punct',
            'inter_fee_setting'         => 'required|numeric',
            'inter_bank_routing_number' => 'required|numeric',
            'inter_bank_company_address' => 'required'
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        }

        $mdata = [
            'inter_bank_account_name' => $inter_bank_account_name,
            'inter_bank_account_number' => $inter_bank_account_number,
            'inter_swift_code' => $inter_bank_swift_code,
            'inter_fee_setting' => $inter_bank_fee_setting,
            'inter_bank_routing_number' => $inter_bank_routing_number,
            'inter_bank_company_address' => $inter_bank_company_address
        ];

        $url = URL_HEDGEFUND . "/non/international-bank";
        // dd($mdata);
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 201) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'International Bank account successfully added.');
        } else {
            $error = $result->messages->email ?? 'Failed to add international bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

    public function updatebankinter()
    {
        $inter_bank_account_name = $this->request->getVar('inter_bank_account_name');
        $inter_bank_account_number = $this->request->getVar('inter_bank_account_number');
        $inter_bank_swift_code = $this->request->getVar('inter_swift_code');
        $inter_bank_fee_setting = $this->request->getVar('inter_fee_setting');
        $inter_bank_routing_number = $this->request->getVar('inter_bank_routing_number');
        $inter_bank_company_address = $this->request->getVar('inter_bank_company_address');

        if (!$this->validate([
            'inter_bank_account_name'   => 'required',
            'inter_bank_account_number' => 'required|numeric',
            'inter_swift_code'          => 'required|numeric',
            'inter_fee_setting'         => 'required|numeric',
            'inter_bank_routing_number' => 'required|numeric',
            'inter_bank_company_address' => 'required'
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/bank_account');
        }

        $mdata = [
            'inter_bank_account_name' => $inter_bank_account_name,
            'inter_bank_account_number' => $inter_bank_account_number,
            'inter_swift_code' => $inter_bank_swift_code,
            'inter_fee_setting' => $inter_bank_fee_setting,
            'inter_bank_routing_number' => $inter_bank_routing_number,
            'inter_bank_company_address' => $inter_bank_company_address
        ];

        $url = URL_HEDGEFUND . "/non/international-bank-update";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 200) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'Bank account successfully updated.');
        } else {
            $error = $result->messages->email ?? 'Failed to update bank account.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/bank_account');
    }

}
