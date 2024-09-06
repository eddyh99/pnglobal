<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Auth extends BaseController
{
	public function index(){
		$mdata = [
			'title'     => 'Active Account - Satoshi Signal' ,
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];            
		return view('widget/layout/wrapper', $mdata);
	}


    public function active_account($token)
    {
        // Call Endpoin Active Account
        $url = URLAPI . "/auth/activate?token=".$token;
        $result = satoshiAdmin($url)->result;

		$mdata = [
			'title'     => 'Active Account - Satoshi Signal' ,
			'content'   => 'widget/auth/active_account_success',
			'extra'     => 'widget/js/_js_subcription',
		];            

		return view('widget/layout/wrapper', $mdata);
    }

    public function send_activation($email)
	{
		$email = urldecode($email);
		$email =  $this->security->xss_clean($email);
		$subject = "Satoshi Signal Activation Account";


		$token = $_GET['token'];

		$message = "
		<!DOCTYPE html>
		<html lang='en'>

		<head>
			<meta name='color-scheme' content='light'>
			<meta name='supported-color-schemes' content='light'>
			<title>Activation Account Satoshi Signal</title>
		</head>

		<body>
			<div style='
			max-width: 420px;
			margin: 0 auto;
			position: relative;
			padding: 1rem;
			'>
				<div style='
				text-align: center;
				padding: 3rem;
				'>
					<h3 style='
					font-weight: 600;
					font-size: 30px;
					line-height: 45px;
					color: #000000;
					margin-bottom: 1rem;
					text-align: center;
					'>
						Dear, User
					</h3>
				</div>

				<div style='
				text-align: center;
				padding-bottom: 1rem;
				'>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Thank you for register Satoshi Signal. To proceed with your request, please click link Active Account Below
					</p>
					<h2><a target='_blank' href='".BASE_URL."auth/active_account/".$token."'></a>".BASE_URL."auth/active_account/".$token."</h2>
					<p style='
					font-weight: 400;
					font-size: 14px;
					color: #000000;
					'>
						Best regards,<br>  
						Satoshi Signal Team

					</p>
				</div>
				<hr>
				<hr>
				<p style='
				text-align: center;
				font-weight: 400;
				font-size: 12px;
				color: #999999;
				'>
					Copyright © " . date('Y') . "
				</p>
			</div>
		</body>
		</html>";

		sendmail_satoshi($email, $subject, $message);
	}
}