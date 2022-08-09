<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{

    public function getUsers()
    {
        $query = $this->db->query("select * from users");
        $res = $query->getResult();

        return $res;
    }

    public function addUser($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'users');
        $builder->insert($data);

        if ($this->db->affectedRows() == 1) {
            return True;
        } else {
            return False;
        }
    }
    
    public function updateUserDetails($data)
    {
        $builder = $this->db->table($this->DBPrefix . 'users');
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
        $builder = $this->db->table($this->DBPrefix . 'users');
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

    public function getUserDetails($id)
    {

        $builder = $this->db->table($this->DBPrefix . 'users');
        $builder->select('name,email,mobile,activation_date,unique_id,status')->where('unique_id', $id);
        $res = $builder->get();

        if (count($res->getResultArray()) == 1) {
            return $res->getRow();
        } else {
            return false;
        }
    }

    public function updateStatus($id)
    {
        $builder = $this->db->table($this->DBPrefix . 'users');
        $builder->where('unique_id', $id);
        $builder->update(['status' => 1]);

        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
