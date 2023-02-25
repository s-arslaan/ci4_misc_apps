<?php

namespace App\Models;
use CodeIgniter\Model;

class HomeModel extends Model
{

    public function getLoginActivity()
    {
        $query = $this->db->query("select * from login_activity");
        $res = $query->getResult();

        return $res;
    }
    
    public function getSuccessfulRescueCount()
    {
        $query = $this->db->query("select count(alert_id) as count from beach_alerts where isRescued = 1");
        $res = $query->getResultArray();

        return $res;
    }
    
    public function getTodaysAlertCount()
    {
        $query = $this->db->query("select count(alert_id) as count from beach_alerts where DATE(timestamp) = CURDATE();
        ");
        $res = $query->getResultArray();

        return $res;
    }
}
