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
}
