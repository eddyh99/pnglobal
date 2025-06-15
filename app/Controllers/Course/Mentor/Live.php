<?php

namespace App\Controllers\Course\Mentor;

use App\Controllers\BaseController;

class Live extends BaseController
{
    public function index() {

        $url = URL_COURSE . "/v1/user/mentor";
        $result = courseAdmin($url)->result;
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
        $response = courseAdmin($url, json_encode(['id' => $id]));
        $result = $response->result;

        if ($result->code != '201') {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/mentor/live');
        } else {
            session()->setFlashdata('success', $result->message);
            return redirect()->to(BASE_URL . 'course/mentor/live');
        }
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
            return redirect()->to(BASE_URL . 'course/mentor/live')->withInput();
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

        $response = courseAdmin(URL_COURSE . "/v1/live/store", json_encode($mdata));
        $result = $response->result;
    
        if ($result->code != 201) {    
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'course/mentor/live')->withInput();
        } 

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'course/mentor/live');
    }


    private function durationToMinutes(string $duration): int {
        list($hours, $minutes) = explode(':', $duration);
        return ((int)$hours * 60) + (int)$minutes;
    }

}