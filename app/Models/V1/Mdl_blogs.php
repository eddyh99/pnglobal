<?php

namespace App\Models\V1;

use CodeIgniter\Model;
use Exception;

/*----------------------------------------------------------
    Modul Name  : Table Blogs
    Desc        : null
    Sub fungsi  : null

------------------------------------------------------------*/


class Mdl_blogs extends Model
{
    protected $server_tz = "Asia/Singapore";
    protected $table      = 'blogs';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title','link','content'];

    protected $returnType = 'object';
    protected $useTimestamps = false;

    public function all_blogs(){
        $sql    = "SELECT * FROM blogs ORDER BY created_at DESC";
        $query  = $this->db->query($sql);
        return $query->getResult();
        
    }
    
    public function post_byID($id){
        $sql    = "SELECT * FROM blogs WHERE id=?";
        $query  = $this->db->query($sql,$id);
        return $query->getRow();
    }
    
    public function add($mdata)
    {
        try {
            $query = $this->insert($mdata);

            if (!$query) {
                return (object) [
                    'code'    => 400,
                    'message' => 'Failed to save posts'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => $e->getMessage()
            ];
        }

        return (object) [
            'code'    => 201,
            'message' => 'Post successful!'
        ];
    }
    
    public function edit($mdata,$post_id)
    {
        try {
            $query = $this->update($post_id,$mdata);

            if (!$query) {
                return (object) [
                    'code'    => 400,
                    'message' => 'Failed to update posts'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => $e->getMessage()
            ];
        }

        return (object) [
            'code'    => 201,
            'message' => 'Post successful!'
        ];
    }
}
