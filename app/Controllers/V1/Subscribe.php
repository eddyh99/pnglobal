<?php

namespace App\Controllers\V1;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Subscribe extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->setting  = model('App\Models\V1\Mdl_settings');
        $this->member  = model('App\Models\V1\Mdl_member');
        $this->subscribe  = model('App\Models\V1\Mdl_subscribe');
    }


    public function postPaid_subscribe()
    {
        $data           = $this->request->getJSON();
        $commission     = $this->setting->get('commission')->message ?? 0;
        $referral_fee   = $this->setting->get('referral_fee')->message ?? 0;
        $member         = $this->member->getby_email(trim($data->email));

        if (@$member->code != 200) {
            return $this->respond(error_msg($member->code, "auth", "01", $member->message), $member->code);
        }

        $invoiceID = 'INV-' . strtoupper(bin2hex(random_bytes(4)));

        $mdata = array(
            "member_id"       => $member->message->id,
            "invoice"         => $invoiceID,
            "initial_capital" => $data->amount,
            "amount_paid"     => ($commission * $data->amount),
            "commission"      => ($commission * $data->amount) * $referral_fee,
            "status"          => 'pending',
            'start_date'      => date("Y-m-d H:i:s"),
            'end_date'        => date("Y-m-d H:i:s", strtotime("+1 month"))
        );

        // if (!empty($data["referral"])){
        //     $level1=$this->member->getby_refcode($data["referral"]);
        // 	if (@$referral->code==400){
        //         return $this->respond(@$referral,$referral->code);
        //     }
        // }

        $result = $this->subscribe->subs_add($mdata);
        if ($result->code !== 201) {
            if ($result->code == 1060 || $result->code == 1062) {
				$result->message = 'User already subscribed';
                $result->code = 400;
			}
            return $this->respond(error_msg($result->code, "auth", '01', $result->message), $result->code);
        }

        $message = [
            "email"     => $data->email,
            "amount"    => $data->amount,
            "end_date"  => $result->message,
            "invoice"   => $invoiceID
        ];

        return $this->respond(error_msg($result->code, "subs", "01", $message), $result->code);
    }

    public function postUpdate_status() {
        $data           = $this->request->getJSON();
        $mdata = [
            'invoice'   => trim($data->invoice),
            'status'    => trim($data->status)
        ];

        $result = $this->subscribe->update_status($mdata);
        if ($result->code !== 201) {
			return $this->respond(error_msg($result->code, "subs", '01', $result->message), $result->code);
		}

        return $this->respond(error_msg(201, "subs", "01", $result->message), 201);
    }

    public function getList_subscribers() {
        $result = $this->subscribe->list_subscribers();
        if ($result->code !== 200) {
			return $this->respond(error_msg($result->code, "subs", '01', $result->message), $result->code);
		}

        return $this->respond(error_msg(200, "subs", "01", $result->message), 200);
    }
}
