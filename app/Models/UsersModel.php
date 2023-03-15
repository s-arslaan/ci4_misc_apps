<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{

    public function getWebUsers()
    {
        $query = $this->db->query("select * from web_users where isAdmin = 0 AND status = 1");
        $res = $query->getResultArray();
        return $res;
    }
    
    public function getBeachUsers()
    {
        $query = $this->db->query("select * from beach_users ORDER BY user_id DESC");
        $res = $query->getResultArray();
        return $res;
    }
    
    public function getAlerts()
    {
        $query = $this->db->query("select ba.alert_id, u.name, u.email, u.gToken, ba.timestamp, ba.latitude, ba.longitude, ba.address, ba.city_name, ba.isRescued, COALESCE(ba.remarks, '') as remarks from beach_alerts ba LEFT JOIN beach_users u ON(u.gToken = ba.gToken) ORDER BY ba.timestamp DESC");
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

    public function deactivate_web_user($unique_id)
    {
        $builder = $this->db->table($this->DBPrefix . 'web_users');
        $builder->where('unique_id', $unique_id);
        $builder->update(['status' => 0]);

        if ($this->db->affectedRows() == 1) {
            return true;
        } else {
            return false;
        }
    }

}
