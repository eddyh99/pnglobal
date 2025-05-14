<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function member()
    {
        $mdata = [
            'title'     => 'Course Member - ' . NAMETITLE,
            'content'   => 'godmode/course/user/member',
            'extra'     => 'godmode/course/user/js/_js_user',
            'active_course'    => 'active active-menu'
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function mentor(){
        $mdata = [
            'title'     => 'Course Mentor - ' . NAMETITLE,
            'content'   => 'godmode/course/user/mentor',
            'extra'     => 'godmode/course/user/js/_js_user',
            'active_course'    => 'active active-menu'
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }

    public function adduser()
    {
        // Validation Field
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required|in_list[member,mentor]'
            ]
        ];

        if ($this->request->getVar('role') == 'member') {
            $rules['amount'] = [
                'label' => 'Payment Amount',
                'rules' => 'required|numeric'
            ];
        }

        // Checking Validation
        if (!$this->validate($rules)) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/user');
        }

        // Init Data
        $role = $this->request->getVar('role');
        $mdata = [
            'email'   => $this->request->getVar('email'),
            'role'  => $role,
            'amount' => $role == 'member' ? $this->request->getVar('amount') : 0
        ];

        // Process API Request
        $url = URL_COURSE . "/v1/user/add_user";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;
        log_message('error', json_encode($result));


        if ($result->code == 201) {
            // Kirim email ke member
            $email = $mdata['email'];
            $otp = $result->message->otp;
            // $email_template = emailtemplate_activation_course($otp, $email);
            // sendmail_satoshi($email, "Activation Account Satoshi Signal", $email_template);

            session()->setFlashdata('success', $result->message->text);
            return redirect()->to(BASE_URL . 'godmode/course/user');
        } else {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user');
        }
    }

    public function get_user()
    {
        // Call Endpoin Get Free Member
        $url = URL_COURSE . "/v1/user/all";
        $result = satoshiAdmin($url)->result;

        echo json_encode($result);
    }

    public function detailpayment($email)
    {

        // Call Get Memeber By Email
        $url = URL_COURSE . "/v1/user/user_byemail?email=" . base64_decode($email);
        $user = satoshiAdmin($url)->result->message;

        $mdata = [
            'title'     => 'Detail Payment - ' . NAMETITLE,
            'content'   => 'godmode/course/detail_payment',
            'user'      => $user

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function setuser_paid($email)
    {
        $url = URL_COURSE . "/v1/user/setpaid_member?email=" . base64_decode($email);
        $response = satoshiAdmin($url);
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/detailpayment/' . $email);
            
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user');
        }
    }

    public function setstatus_user($email, $status)
    {
        $url = URL_COURSE . "/v1/user/setstatus_user";
        $email = base64_decode($email);
        $mdata = [
            'email' => $email,
            'status' => $status
        ];
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user');
        }
    }
}
