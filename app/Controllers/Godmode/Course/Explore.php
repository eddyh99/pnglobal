<?php

namespace App\Controllers\Godmode\Course;

use App\Controllers\BaseController;

class Explore extends BaseController
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

        $mdata = [
            'title'     => 'Explore - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/index',
            'extra'     => 'godmode/course/explore/js/_js_index',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_explore'    => 'active active-menu',
            'url'   => 'godmode/course/'
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function addnew()
    {
        $url = URL_COURSE . "/v1/user/mentor";
        $result = satoshiAdmin($url)->result;

        $mdata = [
            'title'     => 'Add New - ' . NAMETITLE,
            'content'   => 'godmode/course/explore/addnew',
            //'extra'     => 'godmode/course/explore/js/_js_index',
            'sidebar'   => 'course_sidebar',
            'navbar_course' => 'active',
            'active_explore'    => 'active active-menu',
            'mentor'    => $result->message ?? []
        ];

        return view('godmode/layout/admin_wrapper', $mdata);
    }

    public function store()
    {

        $isValid = $this->validate([
            'title' => [
                'label' => 'Title Course',
                'rules' => 'required',
            ],
            'mentor_id' => [
                'label' => 'Mentor',
                'rules' => 'required',
            ],
            'description' => [
                'label' => 'Description Course',
                'rules' => 'required',
            ],
            'cover' => [
                'label' => 'Cover Image',
                'rules' => 'uploaded[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]'
            ],
        ]);


        // Checking Validation
        if (!$isValid) {
            session()->setFlashdata('failed', $this->validation->listErrors());
            return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
        }

        // validate videos
        $videoFiles = $this->request->getFiles()['videos'] ?? [];

        if (!array_filter($videoFiles, fn($video) => $video->isValid() && !$video->hasMoved())) {
            session()->setFlashdata('failed', 'You must upload at least one video.');
            return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
        }

        foreach ($videoFiles as $idx => $video) {
            $no = $idx + 1;

            if (!$video->isValid() || 
                !in_array($video->getClientMimeType(), ['video/mp4', 'video/webm']) || 
                $video->getSize() > 20 * 1024 * 1024) {
                
                $errorMsg = !$video->isValid() ? "Video #$no failed to upload." :
                            (!in_array($video->getClientMimeType(), ['video/mp4', 'video/webm']) ? 
                            "Video #$no must be in mp4 or webm format." : 
                            "Video #$no exceeds the 20MB size limit.");
                
                session()->setFlashdata('failed', $errorMsg);
                return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
            }
        }

        $mdata = [
            'title'        => $this->request->getVar('title'),
            'description'  => $this->request->getVar('description'),
            'mentor_id'    => $this->request->getVar('mentor_id'),
            'cover'        => 'course/course-1.png'
        ];
        $response = satoshiAdmin(URL_COURSE . "/v1/course/store", json_encode($mdata));
        $result = $response->result;

        if ($result->code != 201) {
            session()->setFlashdata('failed', $result->message);
            return redirect()->to(BASE_URL . 'godmode/course/explore/addnew')->withInput();
        }

        session()->setFlashdata('success', $result->message);
        return redirect()->to(BASE_URL . 'godmode/course/explore');
    }

    public function getall_course()
    {
        $url = URL_COURSE . "/v1/course/all_course";
        $response = satoshiAdmin($url);
        $result = $response->result;
    
        $data = [
            'code' => $result->code,
            'message' => $result->message ?? [],
        ];
    
        return $this->response->setJSON($data);
    }

    public function save_video()
{
    $file = $this->request->getFile('video');
    if (!$file) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Video not found.'
        ]);
    }

    if ($this->upload_video_course($file)) {
        return $this->response->setJSON(['success' => true]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed upload video.'
        ]);
    }
}

private function upload_video_course($file)
{
    $ftp_host = FTP_HOSTNAME;
    $ftp_user = FTP_USERNAME;
    $ftp_pass = FTP_PASSWORD;

    $conn = ftp_connect($ftp_host);
    if (!$conn) {
        log_message('error', '❌ FTP Connection Failed.');
        return false;
    }

    if (!ftp_login($conn, $ftp_user, $ftp_pass)) {
        ftp_close($conn);
        log_message('error', '❌ FTP Login Failed.');
        return false;
    }

    ftp_pasv($conn, true);

    if ($file->isValid() && !$file->hasMoved()) {
        $tmpPath  = $file->getTempName();
        $fileName = $file->getRandomName();
        $ftpPath  = "videos/" . $fileName;

        if (!ftp_put($conn, $ftpPath, $tmpPath, FTP_BINARY)) {
            log_message('error', "❌ Upload failed: {$fileName}");
            ftp_close($conn);
            return false;
        }

        log_message('info', "✅ Upload successfull: {$fileName}");
        ftp_close($conn);
        return true;
    }

    ftp_close($conn);
    return false;
}

    
}
