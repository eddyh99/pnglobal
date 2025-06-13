<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Live extends BaseController
{
    public function index() {

        $url = URL_COURSE . "/v1/user/mentor";
        $result = satoshiAdmin($url)->result;
        $mdata = [
            'title'     => 'Live - ' . NAMETITLE,
            'content'   => 'course/mentor/live/index',
            'extra'     => 'course/mentor/live/js/_js_index',
            'active_live'    => 'active active-menu',
            'mentor'    => $result->message ?? []
        ];

        return view('course/layout/mentor_wrapper', $mdata);
    }

    public function get_schedule()
    {
        $url = URL_COURSE . "/v1/live/all_schedule";
        $response = courseAdmin($url);
        $result = $response->result;
    
        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }

    public function deletelive($id)
    {
        $id  = base64_decode($id);

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
}