<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Signal extends BaseController
{
    public function __construct()
    {
        $session = session();
        if(!$session->has('logged_user')){
            header("Location: ". BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }
    
    public function index()
    {
        // Call Endpoin read signal
        $url = URLAPI . "/v1/signal/readsignal";
        $result = satoshiAdmin($url)->result->message;

        // Initial Array Buy A, Buy B, and Buy C
        $buy_a = array();
        $buy_b = array();
        $buy_c = array();
        $buy_d = array();

        // Looping for get type of buy
        foreach($result as $dt){
            // Type Buy A
            if($dt->type == 'Buy A'){
                $buy_a['id'] = $dt->id;
                $buy_a['type'] = $dt->type;
                $buy_a['entry_price'] = intval($dt->entry_price);
                $buy_a['pair_id'] = $dt->pair_id;
                $buy_a['created_at'] = $dt->created_at;

            // Type Buy B
            }else if($dt->type == 'Buy B'){
                $buy_b['id'] = $dt->id;
                $buy_b['type'] = $dt->type;
                $buy_b['entry_price'] = intval($dt->entry_price);
                $buy_b['pair_id'] = $dt->pair_id;
                $buy_b['created_at'] = $dt->created_at;

            // Type Buy C
            }else if($dt->type == 'Buy C'){
                $buy_c['id'] = $dt->id;
                $buy_c['type'] = $dt->type;
                $buy_c['entry_price'] = intval($dt->entry_price);
                $buy_c['pair_id'] = $dt->pair_id;
                $buy_c['created_at'] = $dt->created_at;
            
            // Type Buy D
            }else if($dt->type == 'Buy D'){
                $buy_d['id'] = $dt->id;
                $buy_d['type'] = $dt->type;
                $buy_d['entry_price'] = intval($dt->entry_price);
                $buy_d['pair_id'] = $dt->pair_id;
                $buy_d['created_at'] = $dt->created_at;
            }
        }

        $mdata = [
            'title'     => 'Signal - ' . NAMETITLE,
            'content'   => 'godmode/signal/index',
            'extra'     => 'godmode/signal/js/_js_index',
            'active_signal'    => 'active active-menu',
            'buy_a'      => $buy_a,
            'buy_b'      => $buy_b,
            'buy_c'      => $buy_c,
            'buy_d'      => $buy_d,
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
        if(!$rules){
            echo json_encode($this->validation->listErrors());
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
        $url = URLAPI . "/v1/signal/sendsignal";
        $response = satoshiAdmin($url, json_encode($mdata));
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
            'type-sell'     => [
                'label'     => 'Type Signal',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/signal');
        }

        // Initial Data
        $typesignal = htmlspecialchars($this->request->getVar('type-sell'));
        $mdata = [
            'entry'     => htmlspecialchars($this->request->getVar('price')),
        ];


        // Change format price
        $mdata['entry'] = str_replace(',', '', $mdata['entry']);

        // Looping Check Condition Sell Signal
        // Call Endpoin read signal
        $url = URLAPI . "/v1/signal/readsignal";
        $readsignal = satoshiAdmin($url)->result->message;

        // Initial Alpabhet
        $alphabet = ['A', 'B', 'C', 'D'];
        $result = null;

        // Check Condition Signal Type
        if($typesignal == 'Sell A'){
            foreach($readsignal as $key => $val){
                // Assign value sell signal
                $mdata['type'] = 'Sell ' . $alphabet[$key];
                $mdata['pair_id'] = $val->id;

                // Send Endpoin send signal Sell
                $url = URLAPI . "/v1/signal/sendsignal";
                $result = satoshiAdmin($url, json_encode($mdata))->result;
            }
        }else if($typesignal == 'Sell B'){
            // initial Flag Buy B
            $startCheck = false;
            foreach($readsignal as $key => $val){
                // Get Flag Buy B
                if ($val->type === 'Buy B') {
                    $startCheck = true;
                }

                // Checking Flag Buy B and other
                if ($startCheck) {
                    // Assign value sell signal
                    $mdata['type'] = 'Sell ' . $alphabet[$key];
                    $mdata['pair_id'] = $val->id;

                    // Send Endpoin send signal Sell
                    $url = URLAPI . "/v1/signal/sendsignal";
                    $result = satoshiAdmin($url, json_encode($mdata))->result;
                }
            }
        }else if($typesignal == 'Sell C'){
            // initial Flag Buy C
            $startCheck = false;
            foreach($readsignal as $key => $val){
                // Get Flag Buy C
                if ($val->type === 'Buy C') {
                    $startCheck = true;
                }

                // Checking Flag Buy C and other
                if ($startCheck) {
                    // Assign value sell signal
                    $mdata['type'] = 'Sell ' . $alphabet[$key];
                    $mdata['pair_id'] = $val->id;

                    // Send Endpoin send signal Sell
                    $url = URLAPI . "/v1/signal/sendsignal";
                    $result = satoshiAdmin($url, json_encode($mdata))->result;
                }
            }
        }else if($typesignal == 'Sell D'){
            // initial Flag Buy D
            $startCheck = false;
            foreach($readsignal as $key => $val){
                // Get Flag Buy D
                if ($val->type === 'Buy D') {
                    $startCheck = true;
                }

                // Checking Flag Buy D and other
                if ($startCheck) {
                    // Assign value sell signal
                    $mdata['type'] = 'Sell ' . $alphabet[$key];
                    $mdata['pair_id'] = $val->id;

                    // Send Endpoin send signal Sell
                    $url = URLAPI . "/v1/signal/sendsignal";
                    $result = satoshiAdmin($url, json_encode($mdata))->result;
                }
            }
        }

        if($result->code != '200') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/signal');
        }else{
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/signal');
        }
    }

    public function list_history_order()
    {
        // Call Endpoin List History Order
        $url = URLAPI . "/v1/signal/readhistory";
        $result = satoshiAdmin($url)->result->message;
        echo json_encode($result);
    }
}