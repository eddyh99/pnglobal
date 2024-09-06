<?php

namespace App\Controllers\Godmode;
use App\Controllers\BaseController;

class Dashboard extends BaseController
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
        $resultActive = satoshiAdmin($url)->result->message;

        // Initial Array Buy A, Buy B, and Buy C
        $buy_a = array();
        $buy_b = array();
        $buy_c = array();
        $buy_d = array();

        // Looping for get type of buy
        foreach($resultActive as $dt){
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

        // Call Endpoin total_exclusive
        $url = URLAPI . "/v1/member/total_exclusive";
        $resultExclusive = satoshiAdmin($url)->result->message;

        // Call Endpoin total_member
        $url = URLAPI . "/v1/member/total_member";
        $resultTotalMember = satoshiAdmin($url)->result->message;

        // Call Endpoin total Main Signal
        $url = URLAPI . "/v1/member/total_signal";
        $resultMainSignal = satoshiAdmin($url)->result->message;


        // Call Endpoin total Main Signal
        $url = URLAPI . "/v1/member/total_subsignal";
        $resultSubSignal = satoshiAdmin($url)->result->message;


        
        
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/dashboard/index',
            'extra'     => 'godmode/dashboard/js/_js_index',
            'active_dash'    => 'active',
            'exclusive' => $resultExclusive,
            'totalmember' => $resultTotalMember,
            'mainsignal' => $resultMainSignal,
            'subsignal' => $resultSubSignal,
            'buy_a'  => $buy_a,
            'buy_b'  => $buy_b,
            'buy_c'  => $buy_c,
            'buy_d'  => $buy_d,
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
}