<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Referral extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Referral - ' . NAMETITLE,
            'content'   => 'godmode/referral/index',
            'extra'     => 'godmode/referral/js/_js_index',
            'active_reff'    => 'active active-menu'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function createreferral()
    {
        // Validation Field
        $rules = $this->validate([
            'email'     => [
                'label'     => 'Email',
                'rules'     => 'required|valid_email'
            ],
            'refcode'     => [
                'label'     => 'Referral Code',
                'rules'     => 'required'
            ],
        ]);

        // Checking Validation
        if(!$rules){
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/referral');
        }

        // Init Data
        $mdata = [
            'email'     => htmlspecialchars($this->request->getVar('email')),
            'refcode'     => htmlspecialchars($this->request->getVar('refcode')),
        ];

        // Proccess Endpoin API
        $url = URLAPI . "/v1/member/create_referral";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        
        if($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/referral');
        }else{
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/referral');
        }
    }

    public function detailreferral($type, $email)
    {
        // Decode Type
        $finaltype = base64_decode($type);
                
        // Call Get Memeber By Email
        $url = URLAPI . "/auth/getmember_byemail?email=".base64_decode($email);
        $resultMember = satoshiAdmin($url)->result->message;

        // Call Get Detail Referral
        $url = URLAPI . "/v1/member/detailreferral?id=".$resultMember->id;
        $resultReferral = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Detail Member - ' . NAMETITLE,
            'content'   => 'godmode/referral/detail_referral',
            'extra'     => 'godmode/referral/js/_js_detailreferral',
            'active_reff'  => 'active',
            'member'    => $resultMember,
            'type'      => $finaltype,
            'referral'  => $resultReferral,
            'emailreferral' => base64_decode($email),
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function payreferral($type, $email)
    {
        // Init Data
        $mdata = [
            'id'    => htmlspecialchars($this->request->getVar('id')),
            'type'  => htmlspecialchars($this->request->getVar('type')),
        ];

        // Proccess Endpoin API
        $url = URLAPI . "/v1/member/paid_referral?id=".$mdata['id']."&is_paid=".$mdata['type'];
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        
        if($result->code != '200') {
            session()->setFlashdata('failed', "Something Wrong, Please Try Again!");
            return redirect()->to(BASE_URL . 'godmode/referral/detailreferral/'.$type.'/'.$email);
        }else{

            if($mdata['type'] == 'yes'){
                session()->setFlashdata('success', "Successfully paid transaction");
            }else{
                session()->setFlashdata('success', "Successfully cancel transaction");
            }
            return redirect()->to(BASE_URL . 'godmode/referral/detailreferral/'.$type.'/'.$email);
        }    
        
    }
    
}