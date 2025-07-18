<?php

namespace App\Controllers\Godmode\Onetoone;

use App\Controllers\BaseController;
use App\Models\MemberOnetoOneModel;
use LDAP\Result;

class Dashboard extends BaseController
{
    public function index()
    {
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/onetoone/index',
            'extra'     => 'godmode/onetoone/js/_js_index',
            'sidebar'   => 'onetoone_sidebar',
            'navbar_onetoone' => 'active',
            'active_dash'    => 'active',
            'payment_link'  => session()->getFlashdata('paymentlink')
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }
    
    public function get_member(){
        $url = URL_HEDGEFUND . "/apiv1/onetoone/member";
        $resultMember = satoshiAdmin($url)->result;

        if ($resultMember->code != 200) {
            $resultMember = (object) [
                'data' => [],
            ];
        }
        
        echo json_encode($resultMember->data);
    }

    public function adduser()
    {
        $email = $this->request->getVar('email');

        if (!$this->validate([
            'email' => 'required|valid_email',
        ])) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/onetoone/dashboard');
        }

        $mdata = [
            'email' => $email,
        ];
        // dd($mdata);
        $url = URL_HEDGEFUND . "/apiv1/onetoone/member/add";
        $response = satoshiAdmin($url, json_encode($mdata));
        $result = $response->result;

        if (isset($result->code) && $result->code == 201) {
            session()->setFlashdata('success', is_string($result->message) ? $result->message : 'User successfully added.');
        } else {
            $error = $result->messages->email ?? 'Failed to add user.';
            session()->setFlashdata('failed', $error);
        }

        return redirect()->to(BASE_URL . 'godmode/onetoone/dashboard');
    }

    public function detailmember($id){
        $url = URL_HEDGEFUND . "/apiv1/onetoone/member/". $id;
        $resultMember = satoshiAdmin($url)->result;
        // dd($resultMember);
        // dd($resultMember);
        $mdata = [
            'title'     => 'Dashboard - ' . NAMETITLE,
            'content'   => 'godmode/onetoone/member-detail',
            'extra'     => 'godmode/onetoone/js/_js_member-detail',
            'sidebar'   => 'onetoone_sidebar',
            'navbar_onetoone' => 'active',
            'active_dash'    => 'active',
            'member'       => $resultMember->data->email,
            'id_member' =>$resultMember->data->id,

        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function get_detailmember($id_member)
    {
        $url = URL_HEDGEFUND . "/apiv1/onetoone/member/" . $id_member;
        $resultMember = satoshiAdmin($url)->result;

        if ($resultMember->code != 200) {
            $resultMember = (object) [
                'data' => [],
            ];
        }

        echo json_encode($resultMember);
    }

    public function deleteuser($id)
    {
        $client = \Config\Services::curlrequest();

        $url = URL_HEDGEFUND . "/apiv1/onetoone/member/delete/" . $id;

        try {
            $response = $client->delete($url);

            $body = json_decode($response->getBody());

            if (isset($body->code) && $body->code == 200) {
                session()->setFlashdata('success', $body->message ?? 'User successfully deleted.');
            } else {
                session()->setFlashdata('failed', $body->message ?? 'Failed to delete user.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Delete user error: ' . $e->getMessage());
            session()->setFlashdata('failed', 'An error occurred while deleting the user.');
        }

        return redirect()->to(BASE_URL . 'godmode/onetoone/dashboard');
    }
}
