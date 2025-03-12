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
        // Call Endpoin read signal
        // $url = URLAPI . "/v1/signal/readsignal";
        // $result = satoshiAdmin($url)->result->message;

        // Data dummy untuk testing - kosongkan semua data
        $result = [];

        // Initial Array Buy A, Buy B, and Buy C
        $buy_a = array();
        $buy_b = array();
        $buy_c = array();
        $buy_d = array();

        // Looping for get type of buy
        foreach ($result as $dt) {
            // Type Buy A
            if ($dt->type == 'Buy A') {
                $buy_a['id'] = $dt->id;
                $buy_a['type'] = $dt->type;
                $buy_a['entry_price'] = intval($dt->entry_price);
                $buy_a['pair_id'] = $dt->pair_id;
                $buy_a['created_at'] = $dt->created_at;

                // Type Buy B
            } else if ($dt->type == 'Buy B') {
                $buy_b['id'] = $dt->id;
                $buy_b['type'] = $dt->type;
                $buy_b['entry_price'] = intval($dt->entry_price);
                $buy_b['pair_id'] = $dt->pair_id;
                $buy_b['created_at'] = $dt->created_at;

                // Type Buy C
            } else if ($dt->type == 'Buy C') {
                $buy_c['id'] = $dt->id;
                $buy_c['type'] = $dt->type;
                $buy_c['entry_price'] = intval($dt->entry_price);
                $buy_c['pair_id'] = $dt->pair_id;
                $buy_c['created_at'] = $dt->created_at;

                // Type Buy D
            } else if ($dt->type == 'Buy D') {
                $buy_d['id'] = $dt->id;
                $buy_d['type'] = $dt->type;
                $buy_d['entry_price'] = intval($dt->entry_price);
                $buy_d['pair_id'] = $dt->pair_id;
                $buy_d['created_at'] = $dt->created_at;
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

        // Initial Data
        $mdata = [
            'entry'     => htmlspecialchars($this->request->getVar('price')),
            'type'      => htmlspecialchars($this->request->getVar('type')),
            'pair_id'   => null,
        ];

        // Change format price
        $mdata['entry'] = str_replace(',', '', $mdata['entry']);

        // Proccess Call Endpoin API
        // $url = URLAPI . "/v1/signal/sendsignal";
        // $response = satoshiAdmin($url, json_encode($mdata));
        // $result = $response->result;
        // echo json_encode($result);

        // Untuk testing, kita buat respons dummy
        $result = [
            'code' => '200',
            'message' => 'Signal berhasil dikirim'
        ];

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
            'message' => 'Signal berhasil dikirim'
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

        // Initial Data
        $mdata = [
            'type'      => htmlspecialchars($this->request->getVar('type')),
        ];

        // Proccess Call Endpoin API
        // $url = URLAPI . "/v1/signal/fillsignal";
        // $response = satoshiAdmin($url, json_encode($mdata));
        // $result = $response->result;

        // Untuk testing, kita buat respons dummy
        $result = [
            'code' => '200',
            'message' => 'Signal berhasil diisi'
        ];

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
            'message' => 'Signal berhasil dihapus'
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
