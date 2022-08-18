<?php

namespace App\Models;

use CodeIgniter\Model;


class AttendanceModel extends Model
{
    public function fetchAttendance($type)
    {
        $builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
        $query = $builder->select('*')->where('entry_type', $type)->get();
        return $query->getResultArray();
    }
}