<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Live extends BaseController
{
    public function index() {

        $url = URL_COURSE . "/v1/user/mentor";
        $result = satoshiAdmin($url)->result;
        $mdata = [
            'title'     => 'Live - ' . NAMETITLE,
            'content'   => 'godmode/course/live/index',
            'extra'     => 'godmode/course/live/js/_js_index',
            'active_live'    => 'active active-menu',
            'mentor'    => $result->message ?? []
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }

    public function store() {
        $isValid = $this->validate([
            'title' => [
                'label' => 'Title Course',
                'rules' => 'required',
            ],
            'mentor_id' => [
                'label' => 'Mentor',
                'rules' => 'required|integer',
            ],
            'start_date' => [
                'label' => 'Start Date',
                'rules' => 'required|valid_date',
            ],
            'time' => [
                'label' => 'Time',
                'rules' => 'required',
            ],
            'duration' => [
                'label' => 'Duration',
                'rules' => 'required',
            ]
        ]);
        

        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/live')->withInput();
        }

        $startDateTime = date(
            'Y-m-d H:i:s',
            strtotime($this->request->getVar('start_date') . ' ' . $this->request->getVar('time'))
        );
        
        $mdata = [
            'title'      => $this->request->getVar('title'),
            'mentor_id'  => $this->request->getVar('mentor_id'),
            'start_date' => $startDateTime,
            'duration'   => $this->durationToMinutes($this->request->getVar('duration'))
        ];

        $response = satoshiAdmin(URL_COURSE . "/v1/live/store", json_encode($mdata));
        $result = $response->result;
    
        if ($result->code != 201) {    
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/live')->withInput();
        } 

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/course/live');
    }

    private function durationToMinutes(string $duration): int {
        list($hours, $minutes) = explode(':', $duration);
        return ((int)$hours * 60) + (int)$minutes;
    }

    public function get_schedule()
    {
        $url = URL_COURSE . "/v1/live/all_schedule";
        $response = satoshiAdmin($url);
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

    public function host() {

        $mdata = [
            'title'     => 'Live - ' . NAMETITLE,
            'content'   => 'godmode/course/live/livestream',
            // 'extra'     => 'godmode/course/live/js/_js_livestream',
            'liveroom' => 'd-none',
            'mentor'    => $result->message ?? []
        ];

        return view('godmode/course/layout/admin_wrapper', $mdata);
    }    
    
}