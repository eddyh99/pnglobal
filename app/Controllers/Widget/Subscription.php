<?php

namespace App\Controllers\Widget;

use App\Controllers\BaseController;

class Subscription extends BaseController
{
    public function index()
    {
        // Call Endpoin total_exclusive
        $url = URLAPI . "/auth/readprice";
        $result = satoshiAdmin($url)->result->message;

        $ref = @$_GET['ref'];

        $mdata = [
            'title'     => 'Subscription - Satoshi Signal' ,
            'content'   => 'widget/subscription',
            'extra'     => 'widget/js/_js_subcription',
            'subsprice' => $result,
            'ref'       => $ref
        ];

        return view('widget/layout/wrapper', $mdata);
    }

    public function subsproccess()
    {
        
        $token = htmlspecialchars($this->request->getVar('stripeToken'));
        $subs = htmlspecialchars($this->request->getVar('subs'));

        $array = explode(',', $subs);
        $amount = $array[0];
        $desc = $array[1];

        // echo '<pre>'.print_r($token,true).'</pre>';
        // echo '<pre>'.print_r($amount,true).'</pre>';
        // echo '<pre>'.print_r($desc,true).'</pre>';
        // die;

        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY); 

        try {

            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'eur',
                'description' => $desc,
                'source' => $token,
            ]);
                        
            echo '<pre>'.print_r($charge,true).'</pre>';
            
            // header("Location: ". BASE_URL . 'widget/subscription');
            // exit();
        
        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: '. $e->getError()->message);
            header("Location: ". BASE_URL . 'widget/subscription');
            exit();
        }

    }
}