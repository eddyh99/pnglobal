<?php

namespace App\Controllers;

class Homepage extends BaseController
{
    public function index()
    {
        
        // echo '<pre>'.print_r(base64_encode("HELLO WORLD"),true).'</pre>';
        // die;

        $mdata = [
            'title'     => 'Homepage - ' . NAMETITLE,
            'content'   => 'homepage/index',
            'extra'     => 'homepage/js/_js_index'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }

    public function service()
    {
        $service = base64_decode($_GET['service']);
        
        if($service == "finance_advice_investment"){
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index'
            ];
        }else if($service == "strategic_optimization"){
            $mdata = [
                'title'     => 'Service Strategic And Tax Optimization - ' . NAMETITLE,
                'content'   => 'homepage/service/strategic',
                'extra'     => 'homepage/js/_js_index'
            ];
        }else if($service == "international_expansion_management"){
            $mdata = [
                'title'     => 'Service International Expansion And Management - ' . NAMETITLE,
                'content'   => 'homepage/service/international',
                'extra'     => 'homepage/js/_js_index'
            ];
        }else if($service == "legal_tax_accounting"){
            $mdata = [
                'title'     => 'Service International Expansion And Management - ' . NAMETITLE,
                'content'   => 'homepage/service/legal',
                'extra'     => 'homepage/js/_js_index'
            ];
        }else if($service == "professional_enterpreneurial_training"){
            $mdata = [
                'title'     => 'Service Professional Enterpreneurial Training - ' . NAMETITLE,
                'content'   => 'homepage/service/training',
                'extra'     => 'homepage/js/_js_index'
            ];
        }else{
            $mdata = [
                'title'     => 'Service Finance Advice Assets And Investment - ' . NAMETITLE,
                'content'   => 'homepage/service/finance',
                'extra'     => 'homepage/js/_js_index'
            ];
        }

        return view('homepage/layout/wrapper', $mdata);

    }


    public function contactus()
    {
        $mdata = [
            'title'     => 'Contatc Us - ' . NAMETITLE,
            'content'   => 'homepage/contactus/contactus',
            'extra'     => 'homepage/js/_js_contactus'
        ];

        return view('homepage/layout/wrapper', $mdata);
    }
}
