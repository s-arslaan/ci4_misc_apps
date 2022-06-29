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
}
