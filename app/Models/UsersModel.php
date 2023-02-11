<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{

    public function getWebUsers()
    {
        $query = $this->db->query("select * from web_users where isAdmin = 0");
        $res = $query->getResultArray();
        return $res;
    }
    
    public function getAlerts()
    {
        $query = $this->db->query("select * from beach_alerts");
        $res = $query->getResultArray();
        return $res;
    }

    public function addUser($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->insert($data);

        if ($this->db->affectedRows() == 1) {
            return True;
        } else {
            return False;
        }
    }
    
    public function updateUserDetails($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->where('unique_id', $data['id']);
        $builder->update(['name' => $data['name'], 'mobile' => $data['mobile']]);

        if ($this->db->affectedRows() == 1) {
            return True;
        } else {
            return False;
        }
    }
    
    public function updateUserPassword($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->select('password')->where('unique_id', $data['id']);
        $pass = $builder->get()->getRow()->password;

        if($pass === md5($data['curr_pass'])) {
            
            $builder->where('unique_id', $data['id']);
            $builder->update(['password' => md5($data['new_pass'])]);
    
            if ($this->db->affectedRows() == 1) {
                return True;
            } else {
                return False;
            }
        } else {
            return False;
        }
    }
    
    public function resetPassword($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->where('unique_id', $data['id']);
        $builder->update(['password' => md5($data['new_pass'])]);
    
        if ($this->db->affectedRows() == 1) {
            return True;
        } else {
            return False;
        }
    }

    public function getUserDetails($id)
    {

        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->select('name,email,mobile,unique_id,status,updated_at')->where('unique_id', $id);
        $res = $builder->get();

        if (count($res->getResultArray()) == 1) {
            return $res->getRow();
        } else {
            return false;
        }
    }

    public function updateStatus($id)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->where('unique_id', $id);
        $builder->update(['status' => 1]);

        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function updatedAt($unique_id, $time)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->where('unique_id', $unique_id);
        $builder->update(['updated_at' => $time]);

        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
