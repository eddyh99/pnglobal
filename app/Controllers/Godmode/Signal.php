<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Signal extends BaseController
{
    public function __construct()
    {
        $session = session();

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }

        // Mendapatkan data user yang tersimpan (sudah login)
        $loggedUser = $session->get('logged_user');

        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role !== 'admin') {
            session()->setFlashdata('failed', 'You don\'t have access to this page');
            return redirect()->to(BASE_URL . 'godmode/dashboard');
            exit();
        }

        // Pengecekan akses: hanya yang memiliki akses "signal" yang boleh mengakses halaman ini
        if ($loggedUser->email !== 'a@a.a') {
            $userAccess = json_decode($loggedUser->access, true);
            if (!is_array($userAccess)) {
                $userAccess = array();
            }
            if (!in_array('signal', $userAccess)) {
                session()->setFlashdata('failed', 'You don\'t have access to this page');
                return redirect()->to(BASE_URL . 'godmode/dashboard');
                exit();
            }
        }
    }

    public function index()
    {
        // Call Endpoint read latest signal
        $url = URLAPI . "/v1/order/latestsignal";
        $response = satoshiAdmin($url);
        $result = $response->result->message;

        // Initial Array Buy A, Buy B, Buy C, dan Buy D
        $buy_a = array();
        $buy_b = array();
        $buy_c = array();
        $buy_d = array();

        // Variabel untuk menyimpan ID terbaru untuk setiap tipe buy
        $latest_buy_a_id = 0;
        $latest_buy_b_id = 0;
        $latest_buy_c_id = 0;
        $latest_buy_d_id = 0;

        // Looping untuk mendapatkan data terbaru untuk setiap tipe buy
        foreach ($result as $dt) {
            // Type Buy A
            if ($dt->type == 'Buy A' && $dt->id > $latest_buy_a_id) {
                $latest_buy_a_id = $dt->id;
                $buy_a['id'] = $dt->id;
                $buy_a['type'] = $dt->type;
                $buy_a['entry_price'] = floatval($dt->entry_price);
                $buy_a['status'] = $dt->status;
                // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                $buy_a['pair_id'] = $dt->id;
                if (isset($dt->created_at)) $buy_a['created_at'] = $dt->created_at;
            }
            // Type Buy B
            else if ($dt->type == 'Buy B' && $dt->id > $latest_buy_b_id) {
                $latest_buy_b_id = $dt->id;
                $buy_b['id'] = $dt->id;
                $buy_b['type'] = $dt->type;
                $buy_b['entry_price'] = floatval($dt->entry_price);
                $buy_b['status'] = $dt->status;
                // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                $buy_b['pair_id'] = $dt->id;
                if (isset($dt->created_at)) $buy_b['created_at'] = $dt->created_at;
            }
            // Type Buy C
            else if ($dt->type == 'Buy C' && $dt->id > $latest_buy_c_id) {
                $latest_buy_c_id = $dt->id;
                $buy_c['id'] = $dt->id;
                $buy_c['type'] = $dt->type;
                $buy_c['entry_price'] = floatval($dt->entry_price);
                $buy_c['status'] = $dt->status;
                // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                $buy_c['pair_id'] = $dt->id;
                if (isset($dt->created_at)) $buy_c['created_at'] = $dt->created_at;
            }
            // Type Buy D
            else if ($dt->type == 'Buy D' && $dt->id > $latest_buy_d_id) {
                $latest_buy_d_id = $dt->id;
                $buy_d['id'] = $dt->id;
                $buy_d['type'] = $dt->type;
                $buy_d['entry_price'] = floatval($dt->entry_price);
                $buy_d['status'] = $dt->status;
                // Gunakan id sebagai pair_id karena tidak ada lagi pair_id dalam respons
                $buy_d['pair_id'] = $dt->id;
                if (isset($dt->created_at)) $buy_d['created_at'] = $dt->created_at;
            }
        }

        // Call Endpoin read history all signal
        // $url = URLAPI . "/v1/signal/readhistory";
        // $resultActive = satoshiAdmin($url)->result->message;

        // Data dummy untuk history - kosongkan
        $resultActive = [];

        // initialitation variable dengan tipe data array
        $newarray = [];
        $tempGroup = [];

        // Looping for grouping per period, pembatas field is Buy A again
        foreach ($resultActive as $key => $dt) {
            $temp = (object) [
                'id' => $dt->id,
                'type' => $dt->type,
                'entry_price' => $dt->entry_price,
                'pair_id' => $dt->pair_id,
                'created_at' => $dt->created_at,
                'update_at' => $dt->update_at,
            ];

            array_push($tempGroup,  $temp);

            if ($dt->type == 'Buy A') {
                array_push($newarray, $tempGroup);
                $tempGroup = [];
                // stop hanya index ke 0
                break;
            }
        }

        $session = session();
        $user = $session->get('logged_user');
        $api_key = $user->api_key;
        $api_secret = $user->api_secret;

        // For get instruction last order
        $order = '';
        $lastdate = '';
        $temp_price = '';
        $order = '';
        $lastdate = '';

        $mdata = [
            'title'     => 'Signal - ' . NAMETITLE,
            'content'   => 'godmode/signal/index',
            'extra'     => 'godmode/signal/js/_js_index',
            'active_signal'    => 'active active-menu',
            'buy_a'      => $buy_a,
            'buy_b'      => $buy_b,
            'buy_c'      => $buy_c,
            'buy_d'      => $buy_d,
            'order'      => $order,
            'lastdate'      => $lastdate,
            'api_key'      => $api_key,
            'api_secret'      => $api_secret,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function buysignal()
    {
        // Validation Field
        $rules = $this->validate([
            'price'     => [
                'label'     => 'Entry Price',
                'rules'     => 'required'
            ],
            'type'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            echo json_encode($this->validator->listErrors());
            exit();
        }

        $session = session();
        $user = $session->get('logged_user');
        $admin_id = $user->id;
        $ip_address = $this->request->getIPAddress();

        // Initial Data
        $mdata = [
            'limit'     => htmlspecialchars($this->request->getVar('price')),
            'type'      => htmlspecialchars($this->request->getVar('type')),
            'admin_id'  => $admin_id,
            'ip_address'  => $ip_address,
        ];

        // Change format price
        $mdata['limit'] = str_replace(',', '', $mdata['limit']);

        // Proccess Call Endpoin API
        $url = URLAPI . "/v1/order/limit_buy";
        $response = satoshiAdmin($url, json_encode($mdata));

        // Jika respons berhasil, tambahkan ID sebagai pair_id
        if (isset($response->result) && isset($response->result->id)) {
            $response->result->pair_id = $response->result->id;
        }

        $result = $response->result;
        echo json_encode($result);
    }

    public function sellsignal()
    {
        // Validation Field
        $rules = $this->validate([
            'price'     => [
                'label'     => 'Entry Price',
                'rules'     => 'required'
            ],
            'type'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $response = [
                'code' => '400',
                'message' => $this->validator->listErrors()
            ];
            echo json_encode($response);
            exit();
        }

        // Initial Data
        $mdata = [
            'entry'     => htmlspecialchars($this->request->getVar('price')),
            'type'      => htmlspecialchars($this->request->getVar('type')),
            'pair_id'   => $this->request->getVar('pair_id'),
            'affected_buys' => $this->request->getVar('affected_buys'),
        ];

        // Change format price
        $mdata['entry'] = str_replace(',', '', $mdata['entry']);

        // Proccess Call Endpoin API
        // $url = URLAPI . "/v1/signal/sendsignal";
        // $response = satoshiAdmin($url, json_encode($mdata));
        // $result = $response->result;

        // Untuk testing, kita buat respons dummy
        $result = [
            'code' => '200',
            'message' => 'Signal berhasil dikirim',
            'id' => $mdata['pair_id'] // Mengembalikan ID yang sama sebagai pair_id
        ];

        echo json_encode($result);
    }

    public function fillsignal()
    {
        // Validation Field
        $rules = $this->validate([
            'type'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $response = [
                'code' => '400',
                'message' => $this->validator->listErrors()
            ];
            echo json_encode($response);
            exit();
        }

        // Dapatkan data user yang login    
        $session = session();
        $user = $session->get('logged_user');
        $admin_id = $user->id;
        $ip_address = $this->request->getIPAddress();

        // Initial Data
        $mdata = [
            'type'      => htmlspecialchars($this->request->getVar('type')),
            'admin_id'  => $admin_id,
            'ip_address'  => $ip_address,
        ];

        // Cek apakah tipe adalah BUY atau SELL
        $type = strtoupper($mdata['type']);
        if (strpos($type, 'BUY') !== false) {
            // Jika tipe adalah BUY, gunakan endpoint update_buy
            $url = URLAPI . "/v1/order/update_buy";

            // Tambahkan data tambahan yang mungkin diperlukan untuk endpoint update_buy
            // $mdata['status'] = 'filled'; // Ubah status menjadi filled

            // Log untuk debugging
            log_message('info', 'Mengirim permintaan ke endpoint update_buy: ' . json_encode($mdata));
        } else {
            // Jika tipe adalah SELL, gunakan endpoint fillsignal yang lama
            $url = URLAPI . "/v1/signal/fillsignal";

            // Log untuk debugging
            log_message('info', 'Mengirim permintaan ke endpoint fillsignal: ' . json_encode($mdata));
        }

        // Proccess Call Endpoin API
        $response = satoshiAdmin($url);

        // Log respons untuk debugging
        log_message('info', 'Respons dari endpoint: ' . json_encode($response));

        // Untuk testing atau jika tidak ada respons
        if (!isset($response->result)) {
            $result = [
                'code' => '200',
                'message' => ($type == 'BUY') ? 'Order Successfully Updated' : 'Signal Successfully Filled'
            ];
        } else {
            $result = $response->result;
        }

        echo json_encode($result);
    }

    public function deletesignal()
    {
        // Validation Field
        $rules = $this->validate([
            'type'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if (!$rules) {
            $response = [
                'code' => '400',
                'message' => $this->validator->listErrors()
            ];
            echo json_encode($response);
            exit();
        }

        // Initial Data
        $mdata = [
            'type'      => htmlspecialchars($this->request->getVar('type')),
        ];

        // Proccess Call Endpoin API
        // $url = URLAPI . "/v1/signal/deletesignal";
        // $response = satoshiAdmin($url, json_encode($mdata));
        // $result = $response->result;

        // Untuk testing, kita buat respons dummy
        $result = [
            'code' => '200',
            'message' => 'Signal Successfully Deleted'
        ];

        echo json_encode($result);
    }

    public function list_history_order()
    {
        // Call Endpoin List History Order
        $url = URLAPI . "/v1/order/get_all";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }

    public function cancel_sell()
    {
        $signal_id  = htmlspecialchars($_GET['id']);
        $pair_id    = htmlspecialchars($_GET['pair_id']);
        // $url = URLAPI . "/v1/signal/cancel_sell?id=".$signal_id."&pair_id=".$pair_id;
        // $result = satoshiAdmin($url)->result->message;

        // Untuk testing, kita buat respons dummy
        $result = (object)[
            'code' => '200',
            'message' => 'Signal berhasil dibatalkan'
        ];

        if ($result->code != '200') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/signal');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/signal');
        }
    }
}
