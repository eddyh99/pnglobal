<?php

namespace App\Controllers\Godmode;

use App\Controllers\BaseController;

class Mediation extends BaseController
{

    public function __construct()
    {
        $session = session();
        $loggedUser = $session->get('logged_user');

        // Jika belum login, redirect ke halaman signin
        if (!$session->has('logged_user')) {
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }


        // Pengecekan role: hanya admin yang boleh mengakses halaman ini
        if ($loggedUser->role == 'member') {
            session()->setFlashdata('failed', "You don't have access to this page");
            $session->remove('logged_user');
            header("Location: " . BASE_URL . 'godmode/auth/signin');
            exit();
        }
    }

    public function index()
    {
        $role = $this->session->get('logged_user')->role;

        $mdata = [
            'title'     => 'Mediation - ' . NAMETITLE,
            'content'   => check_access('mediation','godmode/mediation/index','console'),
            'extra'     => 'godmode/mediation/js/_js_index',
            'active_mediation'    => 'active active-menu',
            'sidebar'   => 'console_sidebar',
            'navbar_console' => 'active',
            'role' => $role
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $url = URL_HEDGEFUND . "/calculator/mediation";

        $response = satoshiAdmin($url, json_encode($data));

        if ($response && isset($response->result)) {
            $res = $response->result;

            if (isset($res->success) && $res->success == 1) {
                return redirect()->to(BASE_URL . '/godmode/mediation')
                    ->with('success', $res->message ?? 'Data has been saved successfully');
            } else {
                $errorMessages = [];
                if (isset($res->messages) && is_object($res->messages)) {
                    foreach ($res->messages as $field => $msg) {
                        $errorMessages[] = is_array($msg) ? implode(', ', $msg) : $msg;
                    }
                }
                $errorText = !empty($errorMessages) ? implode(' | ', $errorMessages) : 'Failed to save data';
                return redirect()->to(BASE_URL . '/godmode/mediation')->with('failed', $errorText);
            }
        } else {
            return redirect()->to(BASE_URL . '/godmode/mediation')->with('failed', 'No response from API');
        }
    }

    public function save()
    {
        $data = $this->request->getPost();
        $url  = URL_HEDGEFUND . "/calculator/mediation/" . $data['id'];

        // Kirim data ke API
        
        $response = satoshiAdmin($url, json_encode($data));

        // Pastikan result object
        $result = is_object($response->result) ? $response->result : json_decode($response->result);

        // Cek status dan success
        if ($result && !empty($result->success) && $result->success == true) {
            return redirect()->to('/godmode/mediation')->with('success', $result->message);
        } else {
            $msg = $result->message ?? 'Failed to save data';
            return redirect()->to('/godmode/mediation')->with('failed', $msg);
        }
    }



    public function history()
    {
        $url = URL_HEDGEFUND . "/calculator/mediation";
        $historyData = satoshiAdmin($url);

        // Bersihkan output buffer supaya hanya JSON yang dikirim
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');
        echo json_encode($historyData);
        exit; // pastikan tidak ada output lain
    }
}
