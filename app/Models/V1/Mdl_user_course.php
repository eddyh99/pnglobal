<?php

namespace App\Models\V1;

use CodeIgniter\Model;
use Exception;
use Hashids\Hashids;

/*----------------------------------------------------------
    Modul Name  : Database Member course 
    Desc        : Menyimpan data member course, proses member course
    Sub fungsi  : 
        - getby_id          : Mendapatkan data user dari username
        - change_password   : Ubah password
------------------------------------------------------------*/


class Mdl_user_course extends Model
{
    protected $server_tz = "Asia/Singapore";
    protected $table      = 'user_course';
    protected $primaryKey = 'id';

    protected $protectFields = false;
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Tambahkan data ke database
    public function add($data)
    {
        try {
            $user = $this->db->table("user_course");
            $user->insert($data);

            return (object) [
                'success'  => true,
                'message' => 'User registered successfully'
            ];
        } catch (\Exception $e) {
            return (object) [
                'success'  => false,
                'code'    => $e->getCode(),
                'message' => 'An error occurred.'
            ];
        }
    }

    public function getUsers()
    {

        try {

            $sql = "SELECT * FROM user_course";

            $query = $this->db->query($sql)->getResult();

            if (!$query) {
                return (object) [
                    'code'    => 200,
                    'message' => []
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            "code"    => 200,
            "message"    => $query
        ];
    }

    public function getUser_byEmail($email)
    {

        try {

            $sql = "SELECT * FROM user_course WHERE email = ?";

            $query = $this->db->query($sql, [$email])->getRow();

            if (!$query) {
                return (object) [
                    'code'    => 200,
                    'message' => []
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            "code"    => 200,
            "message"    => $query
        ];
    }

    
    public function setUser_paid($email) {
        try {
            // Cek apakah email ada di database
            $user = $this->where('email', $email)->first();
            
            if (!$user) {
                return (object) [
                    'code'    => 404,
                    'message' => 'User not found'
                ];
            }

            // Update status berdasarkan email
            $this->set(['status' => 'active', 'payment_status' => 'completed'])->where('email', $email)->update();

            return (object) [
                'code'    => 201,
                'message' => 'Payment successfully updated.'
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred while updating payment status' . $e
            ];
        }
    }

    public function setstatus_user($mdata) {
        try {
    
            // Update status "member"
            $this->set(['status' => $mdata['status']])
                 ->where('email', $mdata['email'])
                 ->update();
    
            return (object) [
                'code'    => 201,
                'message' => 'The account has been updated.'
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred'
            ];
        }
    }

    public function reset_password($mdata)
    {
        try {
            // Validasi OTP dan email
            $valid = $this->where('email', $mdata['email'])
                ->where('otp', $mdata['otp'])
                ->first();
    
            if (!$valid) {
                return (object) [
                    'code'    => 400,
                    'message' => 'Invalid token' . ''
                ];
            }
    
            // Update password dan hapus OTP
            $this->set([
                'status' => $valid['status'] == 'new' ? 'active' : $valid['status'],
                'password' => $mdata['password'],
                'otp'    => null // menghapus otp
            ])
            ->where('email', $mdata['email'])
            ->update();
    
            return (object) [
                'code'    => 201,
                'message' => 'Password has been reset successfully'
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred while resetting the password' .$e
            ];
        }
    }

    public function otp_check($mdata)
    {
        try {
            // Validasi OTP dan email
            $valid = $this->where('email', $mdata['email'])
                ->where('otp', $mdata['otp'])
                ->first();
    
            if (!$valid) {
                return (object) [
                    'code'    => 400,
                    'message' => false
                ];
            }

            return (object) [
                'code'    => 200,
                'message' => true
            ];

        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => false
            ];
        }
    }

    public function update_otp($mdata) {
        try {
            // Cek apakah email ada di database
            $member = $this->where('email', $mdata['email'])->first();
            
            if (!$member) {
                return (object) [
                    'code'    => 404,
                    'message' => 'User not found'
                ];
            }

            // Update OTP berdasarkan email
            $this->set('otp', $mdata['otp'])->where('email', $mdata['email'])->update();

            return (object) [
                'code'    => 201,
                'message' => 'Your token has been resent via email'
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred while updating token'
            ];
        }
    }
}
