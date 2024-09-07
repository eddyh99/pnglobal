<?php

namespace App\Controllers\Widget;

use App\Controllers\BaseController;

class Signal extends BaseController
{
    public function index()
    {

        // Call Endpoin read history all signal
        $url = URLAPI . "/v1/signal/readhistory";
        $resultActive = satoshiAdmin($url)->result->message;

        // initialitation variable dengan tipe data array
        $newarray = [];
        $tempGroup = [];

        // Looping for grouping per period, pembatas field is Buy A again
        foreach($resultActive as $key => $dt){

            $temp = (object) [
                'id' => $dt->id,
                'type' => $dt->type,
                'entry_price' => $dt->entry_price,
                'pair_id' => $dt->pair_id,
                'created_at' => $dt->created_at,
                'update_at' => $dt->update_at,
            ];

            array_push($tempGroup,  $temp);

            if($dt->type == 'Buy A'){
                array_push($newarray, $tempGroup);
                $tempGroup = [];
                // stop hanya index ke 0
                break; 
            }
        }

        // Initialitation type data array dengan deretan A
        $buy_a = [];
        $sell_a = [];
        $temp_a_pair = null;
        // Looping array baru tersebut dengan index ke 0
        // For get Only Buy A or get Buy A and Sell A for the last order
        foreach($newarray[0] as $key => $dt){
            if($dt->type == 'Buy A' && $dt->pair_id == null){
                // Assign buy A 
                $buy_a['id'] = $dt->id;
                $buy_a['type'] = $dt->type;
                $buy_a['entry_price'] = intval($dt->entry_price);
                $buy_a['pair_id'] = $dt->pair_id;
                $buy_a['created_at'] = $dt->created_at;
                break;
    
            }else if($dt->type == 'Sell A' && $dt->pair_id != null || $dt->type == 'Buy A' && $dt->pair_id != null){
                
                if($dt->type == 'Sell A'){
                    $temp_a_pair = $dt->pair_id;
                    $sell_a['id'] = $dt->id;
                    $sell_a['type'] = $dt->type;
                    $sell_a['entry_price'] = intval($dt->entry_price);
                    $sell_a['pair_id'] = $dt->pair_id;
                    $sell_a['created_at'] = $dt->created_at;
                }

                if($dt->type == 'Buy A' && $dt->pair_id == $temp_a_pair) {
                    $buy_a['id'] = $dt->id;
                    $buy_a['type'] = $dt->type;
                    $buy_a['entry_price'] = intval($dt->entry_price);
                    $buy_a['pair_id'] = $dt->pair_id;
                    $buy_a['created_at'] = $dt->created_at;
                    break;
                }
            }
        }

        // Initialitation type data array dengan deretan B
        $buy_b = [];
        $sell_b = [];
        $temp_b_pair = null;
        // Looping array baru tersebut dengan index ke 0
        // For get Only Buy B or get Buy B and Sell B for the last order
        foreach($newarray[0] as $key => $dt){
            if($dt->type == 'Buy B' && $dt->pair_id == null){

                $buy_b['id'] = $dt->id;
                $buy_b['type'] = $dt->type;
                $buy_b['entry_price'] = intval($dt->entry_price);
                $buy_b['pair_id'] = $dt->pair_id;
                $buy_b['created_at'] = $dt->created_at;
                break;

            } else if($dt->type == 'Sell B' && $dt->pair_id != null || $dt->type == 'Buy B' && $dt->pair_id != null){
               
                if($dt->type == 'Sell B'){
                    $temp_b_pair = $dt->pair_id;
                    $sell_b['id'] = $dt->id;
                    $sell_b['type'] = $dt->type;
                    $sell_b['entry_price'] = intval($dt->entry_price);
                    $sell_b['pair_id'] = $dt->pair_id;
                    $sell_b['created_at'] = $dt->created_at;
                }

                if($dt->type == 'Buy B' && $dt->pair_id == $temp_b_pair) {
                    $buy_b['id'] = $dt->id;
                    $buy_b['type'] = $dt->type;
                    $buy_b['entry_price'] = intval($dt->entry_price);
                    $buy_b['pair_id'] = $dt->pair_id;
                    $buy_b['created_at'] = $dt->created_at;
                    break;
                }
            }
        }


        // Initialitation type data array dengan deretan C
        $buy_c = [];
        $sell_c = [];
        $temp_c_pair = null;
        // Looping array baru tersebut dengan index ke 0
        // For get Only Buy C or get Buy C and Sell C for the last order
        foreach($newarray[0] as $key => $dt){
            if($dt->type == 'Buy C' && $dt->pair_id == null){

                $buy_c['id'] = $dt->id;
                $buy_c['type'] = $dt->type;
                $buy_c['entry_price'] = intval($dt->entry_price);
                $buy_c['pair_id'] = $dt->pair_id;
                $buy_c['created_at'] = $dt->created_at;
                break;

            } else if($dt->type == 'Sell C' && $dt->pair_id != null || $dt->type == 'Buy C' && $dt->pair_id != null){
               
                if($dt->type == 'Sell C'){
                    $temp_c_pair = $dt->pair_id;
                    $sell_c['id'] = $dt->id;
                    $sell_c['type'] = $dt->type;
                    $sell_c['entry_price'] = intval($dt->entry_price);
                    $sell_c['pair_id'] = $dt->pair_id;
                    $sell_c['created_at'] = $dt->created_at;
                }

                if($dt->type == 'Buy C' && $dt->pair_id == $temp_c_pair) {
                    $buy_c['id'] = $dt->id;
                    $buy_c['type'] = $dt->type;
                    $buy_c['entry_price'] = intval($dt->entry_price);
                    $buy_c['pair_id'] = $dt->pair_id;
                    $buy_c['created_at'] = $dt->created_at;
                    break;
                }
            }
        }


        // Initialitation type data array dengan deretan D
        $buy_d = [];
        $sell_d = [];
        $temp_d_pair = null;
        // Looping array baru tersebut dengan index ke 0
        // For get Only Buy D or get Buy D and Sell D for the last order
        foreach($newarray[0] as $key => $dt){
            if($dt->type == 'Buy D' && $dt->pair_id == null){

                $buy_d['id'] = $dt->id;
                $buy_d['type'] = $dt->type;
                $buy_d['entry_price'] = intval($dt->entry_price);
                $buy_d['pair_id'] = $dt->pair_id;
                $buy_d['created_at'] = $dt->created_at;
                break;

            } else if($dt->type == 'Sell D' && $dt->pair_id != null || $dt->type == 'Buy D' && $dt->pair_id != null){
               
                if($dt->type == 'Sell D'){
                    $temp_d_pair = $dt->pair_id;
                    $sell_d['id'] = $dt->id;
                    $sell_d['type'] = $dt->type;
                    $sell_d['entry_price'] = intval($dt->entry_price);
                    $sell_d['pair_id'] = $dt->pair_id;
                    $sell_d['created_at'] = $dt->created_at;
                }

                if($dt->type == 'Buy D' && $dt->pair_id == $temp_d_pair) {
                    $buy_d['id'] = $dt->id;
                    $buy_d['type'] = $dt->type;
                    $buy_d['entry_price'] = intval($dt->entry_price);
                    $buy_d['pair_id'] = $dt->pair_id;
                    $buy_d['created_at'] = $dt->created_at;
                    break;
                }
            }
        }


        // For get instruction last order
        $order = '';
        $temp_price = '';
        foreach($newarray[0] as $key => $dt){

            $type = explode(" ", $dt->type);

            if($key == 0){
                $order = $dt->type;
                $temp_price = $dt->entry_price;

                if($type[0] == 'Buy'){
                    $order = $dt->type;
                    break;
                }
            }

            if($type[0] == 'Sell' && $dt->entry_price == $temp_price){
                $order = $dt->type;
            }

            if($type[0] == 'Buy'){
                break;
            }

        }


        $mdata = [
            'title'     => 'Signal - ' . SATOSHITITLE ,
            'content'   => 'widget/signal/index',
            'extra'     => 'widget/signal/js/_js_index',
            'buy_a'     => $buy_a,
            'sell_a'    => $sell_a,
            'buy_b'     => $buy_b,
            'sell_b'    => $sell_b,
            'buy_c'     => $buy_c,
            'sell_c'    => $sell_c,
            'buy_d'     => $buy_d,
            'sell_d'    => $sell_d,
            'order'     => $order
        ];

        return view('widget/layout/wrapper', $mdata);
    }

}