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
            'extra'     => 'godmode/course/user/js/_js_member',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_member'    => 'active active-menu',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
    
    public function mentor(){
        $mdata = [
            'title'     => 'Course Mentor - ' . NAMETITLE,
            'content'   => 'godmode/course/user/mentor',
            'extra'     => 'godmode/course/user/js/_js_mentor',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_mentor'    => 'active active-menu',
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function adduser()
    {
        $email = $this->request->getVar('email');
        $role  = $this->request->getVar('role');
    
        if (!$this->validate([
            'email' => 'required|valid_email',
            'role'  => 'required'
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/user/' . $role);
        }
    
        $mdata = [
            'email' => $email,
            'role'  => $role
        ];
        $response = satoshiAdmin(URL_COURSE . "/v1/user/add_user", json_encode($mdata));
        $result = $response->result;
    
        if ($result->code == 201) {
            // Optional: Kirim email aktivasi
            $otp = $result->message->otp;
            $template = emailtemplate_activation_course($otp, $email);
            $subject = "Activation Account - PNGLOBAL COURSE";
            sendmail_satoshi($mdata['email'], $subject,  $template,"PNGLOBAL COURSE",USERNAME_MAIL);
    
            session()->setFlashdata('success', $result->message->text);
        } else {
            session()->setFlashdata('failed', $result->message);
        }
    
        return redirect()->to(BASE_URL . 'godmode/course/user/' . $role);
    }    

    public function get_member()
    {
        // Call Endpoin Get Member
        $url = URL_COURSE . "/v1/user/member";
        $result = satoshiAdmin($url)->result;

        echo json_encode($result);
    }

    public function get_mentor()
    {
        // Call Endpoin Get Mentor
        $url = URL_COURSE . "/v1/user/mentor";
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

    public function setstatus_user($dest, $email, $status)
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
            return redirect()->to(BASE_URL . 'godmode/course/user/' . $dest);
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user/' . $dest);
        }
    }

    public function deleteuser($dest, $email)
    {
        $id  = base64_decode($email);

        $url = URL_COURSE . "/v1/live/destroy";
        $response = satoshiAdmin($url, json_encode(['id' => $id]));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/live/');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/live/');
        }
    }
    
    public function tradehistory($email = null){
        $email = base64_decode($email);
        $mdata = [
            'title'     => 'Course Member - ' . NAMETITLE,
            'content'   => 'godmode/course/trade/index',
            'extra'     => 'godmode/course/trade/js/_js_index',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_member'    => 'active active-menu',
            'email'     => $email
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }
    
    public function trade_history()
    {
        $email = $this->request->getVar('email');
        // Call Endpoin Get Member
        $url = URL_COURSE . "/v1/demo/trade_historybyemail?email=".$email;
        $result = satoshiAdmin($url)->result->message;

        echo json_encode($result);
    }
    
    public function openexam(){
        $email      = filter_var($this->request->getVar('modal_email'), FILTER_VALIDATE_EMAIL);
        $capital    = $this->request->getVar('capital');
        $data = array(
                "email"     => $email,
                "capital"   => $capital
            );
        $url = URL_COURSE . "/v1/demo/open_exam";
        $result = satoshiAdmin($url,json_encode($data))->result;
        if ($result->code != '200') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user/member');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user/member');
        }

    }
    
    public function reopen(){
        $trade_id  = $this->request->getVar('trade_id');
        $status    = $this->request->getVar('status');
        $data = array(
                "trade_id"  => base64_decode($trade_id),
                "status"    => $status
            );
            
        $url = URL_COURSE . "/v1/demo/reopen";
        $result = satoshiAdmin($url,json_encode($data))->result;
        if ($result->code != '200') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user/member');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/user/member');
        }
    }
}
