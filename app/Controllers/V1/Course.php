<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Course extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->userCourse  = model('App\Models\V1\Mdl_user_course');
    }

    public function postAdd_user() {
        $data = $this->request->getJSON();

        $mdata = [
            'email'  => trim($data->email),
            'role'   => trim($data->role),
            'amount' => trim($data->amount)
        ];
        $mdata['otp'] = rand(1000, 9999);
		$result = $this->userCourse->add($mdata);

		if (!@$result->success) {
			if ($result->code == 1060 || $result->code == 1062) {
				$result->message = $mdata['role'] . ' already registered';
			}
			return $this->respond(error_msg(400, "auth", '01', $result->message), 400);
		}

        $message = [
			"text" => $result->message,
			"otp"	  => $mdata['otp']
		];

        return $this->respond(error_msg(201, "user", null, $message), 201);
    }

    public function getUsers()
    {
        $result = $this->userCourse->getUsers();
        return $this->respond(error_msg($result->code, "user", null, $result->message), $result->code);
    }

    public function getUser_byemail() {
        $email = filter_var($this->request->getVar('email'), FILTER_SANITIZE_EMAIL);
        $result = $this->userCourse->getUser_byEmail($email);

        if (@$result->code != 200) {
            return $this->respond(error_msg($result->code, "user", "01", $result->message), $result->code);
        }

        return $this->respond(error_msg(200, "user", null, $result->message), 200);
    }

    public function getSetpaid_member() {
        $email = filter_var($this->request->getVar('email'), FILTER_SANITIZE_EMAIL);
        $result = $this->userCourse->setUser_paid($email);

        if (@$result->code != 201) {
            return $this->respond(error_msg($result->code, "user", "01", $result->message), $result->code);
        }

        return $this->respond(error_msg(201, "user", null, $result->message), 201);
    }

    public function postSetstatus_user() {
        $data = $this->request->getJSON();
        $mdata = [
            "email" => $data->email,
            "status" => $data->status
        ];

        $result = $this->userCourse->setstatus_user($mdata);
        if (@$result->code != 201) {
			return $this->respond(error_msg($result->code, "member", "01", $result->message), $result->code);
		}

        return $this->respond(error_msg(201, "member", null, $result->message), 201);
    }

}