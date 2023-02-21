<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{

    public function storeAlert($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'beach_alerts');
        $builder->insert($data);

        if ($this->db->affectedRows() == 1) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }
    
    public function addBeachUser($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'beach_users');

        $query = $builder->select('*')->where('gToken', $data['gToken'])->get();
        $storedUser = $query->getResultArray();

        if(count($storedUser) > 0) {
            return 2;
        } else {
            $builder->insert($data);
            if ($this->db->affectedRows() == 1) {
                // return $this->db->insertID();
                return 1;
            } else {
                return 0;
            }
        }


    }
}
