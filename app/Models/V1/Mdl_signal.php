<?php

namespace App\Models\V1;

use CodeIgniter\Model;
use Exception;

/*----------------------------------------------------------
    Modul Name  : Database Signal
    Desc        : null
    Sub fungsi  : null

------------------------------------------------------------*/


class Mdl_signal extends Model
{
    protected $server_tz = "Asia/Singapore";
    protected $table      = 'sinyal';
    protected $primaryKey = 'id';

    protected $allowedFields = ['type', 'entry_price', 'pair_id', 'is_deleted', 'status'];

    protected $returnType = 'array';
    protected $useTimestamps = true;

    public function add($mdata, $sell = false)
    {
        try {

            // Insert batch data ke database
            $signal = $this->db->table("sinyal");

            if (!$signal->insert($mdata)) {
                return (object) [
                    "code"    => 500,
                    "message" => "Failed to insert signal"
                ];
            }

            $id = $this->db->insertID();

            if ($sell) {
                $pair_id = $mdata['pair_id'];
                $signal->where('id', $pair_id)->update(['pair_id' => $pair_id]);
            }            

            return (object) [
                'code'    => 201,
                'message' => 'Signal has been successfully added.',
                'id'      => $id
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred.'
            ];
        }
    }

    public function fill_order($id) {
        try {
            // Update order status to "filled"
            $this->set(['status' => 'filled'])
                 ->where('id', $id)
                 ->update();

            if ($this->affectedRows() === 0) {
                return (object) [
                    'code'    => 404,
                    'message' => 'No order was updated.'
                ];
            }
    
            return (object) [
                'code'    => 201,
                'message' => 'Order status has been filled.'
            ];
        } catch (\Exception $e) {
            return (object) [
                'code'    => 500,
                'message' => 'An error occurred while updating the order status.'
            ];
        }
    }

    public function get_signals_for_sell($id_signal)
    {
        try {
            $sql = "SELECT
                        ms.sinyal_id as id_sinyal,
                        ms.amount_btc,
                        ms.member_id as id,
                        m.api_key,
                        m.api_secret
                    FROM
                        member_sinyal ms
                        INNER JOIN member m ON m.id = ms.member_id
                    where
                        ms.sinyal_id = ?";
            $query = $this->db->query($sql, [$id_signal])->getResult();

            if (!$query) {
                return (object) [
                    'code' => 404,
                    'message' => 'Orders not found.'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred.' .$e
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function get_orders($id_signal)
    {
        try {
            $sql = "SELECT
                        ms.order_id,
                        m.api_key,
                        m.api_secret
                    FROM
                        member_sinyal ms
                        INNER JOIN member m ON m.id = ms.member_id
                    WHERE
                    ms.sinyal_id = ?";
            $query = $this->db->query($sql, [$id_signal])->getResult();

            if (!$query) {
                return (object) [
                    'code' => 404,
                    'message' => 'Orders not found.'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred.'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function get_buy_order_pending($id_signal)
    {
        try {
            $sql = "SELECT
                        ms.member_id,
                        ms.order_id,
                        m.api_key,
                        m.api_secret
                    FROM
                        member_sinyal ms
                        INNER JOIN member m ON m.id = ms.member_id
                    WHERE
                        ms.sinyal_id = ?";
            $query = $this->db->query($sql, [$id_signal])->getResult();

            if (!$query) {
                return (object) [
                    'code' => 400,
                    'message' => 'No pending buy orders found!'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function get_sell_order_pending()
    {
        try {
            $sql = "SELECT
                        sinyal.id, 
                        sinyal.type,
                        ms.member_id,
                        ms.order_id,
                        m.api_key,
                        m.api_secret
                    FROM sinyal
                    INNER JOIN member_sinyal ms ON ms.sinyal_id = sinyal.id
                    INNER JOIN member m ON m.id = ms.member_id
                    WHERE 
                        sinyal.status = 'pending'
                        AND sinyal.is_deleted = 'no'
                        AND sinyal.type IN ('Sell A', 'Sell B', 'Sell C', 'Sell D')
                    GROUP BY sinyal.type
                    ";
            $query = $this->db->query($sql)->getResult();

            if (!$query) {
                return (object) [
                    'code' => 400,
                    'message' => 'No pending sell orders found!'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function get_latest_signals_buy()
    {
        try {
            $sql = "SELECT
                        id,
                        type,
                        entry_price,
                        status
                    FROM
                        sinyal
                    WHERE
                        sinyal.status != 'canceled'
                        AND type LIKE 'Buy%'
                        AND pair_id IS NUll
                        AND is_deleted = 'no'";
            $query = $this->db->query($sql)->getResult();

            if (!$query) {
                return (object) [
                    'code' => 200,
                    'message' => []
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function update_status_order($mdata)
    {

        try {
            // Start Transaction
            $this->db->transBegin();
    
            // Table initialization
            $member_signal = $this->db->table("member_sinyal");
    
            // Jika lebih dari 1 data, gunakan updateBatch()
            if(!empty($mdata['orders'])) {
                if (count($mdata['orders']) > 1) {
                    if (!$member_signal->updateBatch($mdata['orders'], 'order_id')) {
                        $this->db->transRollback();
                        return (object) [
                            "code"    => 400,
                            "message" => "Failed to update orders"
                        ];
                    }
                } else {
                    // Jika hanya 1 data, gunakan update()
                    $order = $mdata['orders'][0];
                    if (!$member_signal->where('order_id', $order['order_id'])->update($order)) {
                        $this->db->transRollback();
                        return (object) [
                            "code"    => 400,
                            "message" => "Failed to update order"
                        ];
                    }
                }
            }
    
            // Pastikan order_ids tidak kosong sebelum diproses
            // $order_ids = array_map('intval', $mdata['order_ids']);
            // if (empty($order_ids)) {
            //     $this->db->transRollback();
            //     return (object) [
            //         "code"    => 400,
            //         "message" => "No order IDs provided"
            //     ];
            // }
    
            // Update status di tabel sinyal menggunakan Query Builder
            // $this->db->table('sinyal')
            //     ->whereIn('id', function ($builder) use ($order_ids) {
            //         $builder->select('sinyal_id')
            //                 ->from('member_sinyal')
            //                 ->whereIn('order_id', $order_ids);
            //     })
            //     ->update(['status' => 'FILLED']);
    
            // Commit transaksi
            $this->db->transCommit();
    
            return (object) [
                "code"    => 201,
                "message" => "Success"
            ];
        } catch (\Exception $e) {
            // Rollback jika ada error
            $this->db->transRollback();
    
            // Log error untuk debugging
            log_message('error', $e->getMessage());
    
            return (object) [
                "code"    => 500,
                "message" => "An internal server error occurred"
            ];
        }
    }
    

    public function get_amountBTC_last_order($id_signal)
    {
        $placeholders = implode(',', array_fill(0, count($id_signal), '?'));
        try {
            // $sql = "WITH latest_buy AS (
            //             SELECT 
            //                 id, 
            //                 type, 
            //                 ROW_NUMBER() OVER (PARTITION BY type ORDER BY created_at DESC) AS rn
            //             FROM sinyal
            //             WHERE type IN ($placeholders)
            //             AND status = 'filled'
            //             AND is_deleted = 'no'
            //         )
            //         SELECT
            //             ms.member_id,
            //             SUM(ms.amount_btc) AS total_amount_btc
            //         FROM 
            //             member_sinyal ms
            //         JOIN 
            //             sinyal s ON ms.sinyal_id = s.id
            //         WHERE 
            //             s.id IN (SELECT id FROM latest_buy WHERE rn = 1)  -- Hanya transaksi terbaru tiap tipe
            //         GROUP BY 
            //             ms.member_id
            //         ORDER BY 
            //             total_amount_btc DESC";

            $sql = "SELECT
                        ms.member_id,
                        SUM(ms.amount_btc) AS total_amount_btc
                    FROM
                        member_sinyal ms
                    WHERE
                    ms.sinyal_id IN ($placeholders)
                    GROUP BY
                        ms.member_id
                    ORDER BY
                        total_amount_btc Desc";
            $query = $this->db->query($sql, $id_signal)->getResult();

            if (!$query) {
                return (object) [
                    'code' => 400,
                    'message' => 'Not Found'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred' . $e
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }
    

    public function get_all()
    {
        try {
            $sql = "SELECT
                        s.id,
                        s.status,
                        s.type,
                        s.entry_price,
                        COALESCE(mr.alias, 'unknown') AS admin,
                        DATE(s.created_at) AS date,
                        TIME(s.created_at) AS time
                    FROM
                        sinyal s
                        LEFT JOIN member_role mr ON mr.member_id = s.admin_id
                    ORDER BY date DESC, time DESC";
            $query = $this->db->query($sql)->getResult();

            if (!$query) {
                return (object) [
                    'code' => 200,
                    'message' => []
                ];
            }
        } catch (\Throwable $th) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function get_latest_signal(array $types)
    {
        $placeholders = implode(',', array_fill(0, count($types), '?'));
        try {
            $sql = "WITH LatestSinyal AS (
                        SELECT *,
                            ROW_NUMBER() OVER (PARTITION BY type ORDER BY created_at DESC) AS rn
                        FROM sinyal
                        WHERE
                            type IN ($placeholders)
                            AND is_deleted = 'no'
                            AND status = 'filled'
                            AND pair_id IS NULL
                    )
                    SELECT 
                        ls.id AS sinyal_id, 
                        ls.type, 
                        ls.created_at, 
                        ms.id AS member_sinyal_id,
                        ms.amount_btc, 
                        ms.member_id as id,
                        m.api_key,
                        m.api_secret
                    FROM LatestSinyal ls
                    INNER JOIN member_sinyal ms ON ms.sinyal_id = ls.id
                    INNER JOIN member m ON m.id = ms.member_id
                    WHERE ls.rn = 1
                    ORDER BY ls.type, ls.created_at DESC";

            $query = $this->db->query($sql, $types)->getResult();

            if (!$query) {
                return (object) [
                    'code' => 400,
                    'message' => 'Not Found'
                ];
            }
        } catch (\Throwable $th) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred.'
            ];
        }

        return (object) [
            'code' => 200,
            'message' => $query
        ];
    }

    public function destroy($id_signal) {
        try {
            // Update status dan is_deleted di tabel signals

            $signal = $this->db->table('sinyal')->where('id', $id_signal)->get()->getRow();

            if (!$signal) {
                return (object) ['code' => 404, 'message' => 'Signal not found.'];
            }

            $this->db->table('sinyal')->where('id', $id_signal)->update([
                'status' => 'canceled',
                'is_deleted' => 'yes'
            ]);
            
            if (str_starts_with(strtolower($signal->type), 'sell') && $signal->pair_id) {
                $this->db->table('sinyal')->where('id', $signal->pair_id)
                ->update(['pair_id' => NULL]);
            }            
    
            // Periksa apakah ada baris yang terpengaruh
            if ($this->db->affectedRows() === 0) {
                return (object) [
                    'code' => 400,
                    'message' => 'Failed.'
                ];
            }
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
        }
    
        return (object) [
            'code' => 201,
            'message' => 'Signal has been deleted.'
        ];
    }

    public function truncate()
    {
        try {
            // Cek apakah ada order dengan status "new"
            $query = $this->db->table('sinyal')->where('status', 'pending')->countAllResults();

            if ($query > 0) {
                return (object) [
                    'code' => 400,
                    'message' => "There are pending orders. Cancel them first."
                ];
            }


            // Truncate tabel
            $this->db->query("SET FOREIGN_KEY_CHECKS=0;");

            // Truncate tabel
            $this->db->query("TRUNCATE TABLE sinyal;");
            $this->db->query("TRUNCATE TABLE member_sinyal;");

            // Aktifkan kembali foreign key check
            $this->db->query("SET FOREIGN_KEY_CHECKS=1;");

            return (object) [
                'code' => 201,
                'message' => "Tables truncated successfully."
            ];
        } catch (\Exception $e) {
            return (object) [
                'code' => 500,
                'message' => "An error occurred"
            ];
        }
    }
    
}
