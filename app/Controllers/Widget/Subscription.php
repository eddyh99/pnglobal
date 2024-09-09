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
        $email = @$_GET['mail'];

        $mdata = [
            'title'     => 'Subscription - Satoshi Signal' ,
            'content'   => 'widget/subscription/subscription',
            'extra'     => 'widget/subscription/js/_js_subcription',
            'subsprice' => $result,
            'ref'       => $ref,
            'email'     => $email
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

        $email = @$_GET['mail'];


        // Stripe secret key
        \Stripe\Stripe::setApiKey(SECRET_KEY); 

        try {

            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'eur',
                'description' => $desc,
                'source' => $token,
            ]);
                        
            header("Location: ". BASE_URL . 'widget/subscription/success?mail='.$email);
            exit();

        } catch (\Stripe\Exception\CardException $e) {
            session()->setFlashdata('failed', 'Payment Failed: '. $e->getError()->message);
            header("Location: ". BASE_URL . 'widget/subscription');
            exit();
        }
    }

    public function success()
    {
        $email = @$_GET['mail'];

        $mdata = [
            'title'     => 'Subscription Success - Satoshi Signal' ,
            'content'   => 'widget/subscription/success',
            'extra'     => 'widget/subscription/js/_js_success',
            'email'     => $email
        ];

        return view('widget/layout/wrapper', $mdata);
    }
}