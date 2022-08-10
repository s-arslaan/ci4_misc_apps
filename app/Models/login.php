<?php

namespace App\Models;

use CodeIgniter\Model;

class Login extends Model
{

    public function searchEmail($email)
    {
        $builder = $this->db->table($this->DBPrefix . 'users');
        $builder->select('*')->where('email', $email);
        $res = $builder->get();

        if (count($res->getResultArray()) != 0) {
            return $res->getRow();
        } else {
            return false;
        }
    }

    public function saveLoginInfo($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'login_activity');
        $builder->insert($data);

        if ($this->db->affectedRows() == 1) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }

    public function updateLogoutTime($la_id, $time)
    {
        $builder = $this->db->table($this->DBPrefix . 'login_activity');
        $builder->where('activity_id', $la_id);
        $builder->update(['logout_time' => $time]);

        if ($this->db->affectedRows() == 1) {
            return true;
        }
    }
    
    public function updatedAt($unique_id, $time)
    {
        $builder = $this->db->table($this->DBPrefix . 'users');
        $builder->where('unique_id', $unique_id);
        $builder->update(['updated_at' => $time]);

        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
