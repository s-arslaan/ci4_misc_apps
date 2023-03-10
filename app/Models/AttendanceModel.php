<?php

namespace App\Models;

use CodeIgniter\Model;


class AttendanceModel extends Model
{
    public function fetchAttendance($type)
    {
        $builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
        // $query = $builder->select('*, ROW_NUMBER() OVER (ORDER BY attendance_id DESC) AS id')->where('entry_type', $type)->getCompiledSelect();
        $query = $builder->select('*, ROW_NUMBER() OVER (ORDER BY attendance_id) AS id')->where('entry_type', $type)->get();
        return $query->getResultArray();
    }
    
    public function getUniqueNames()
    {
        $builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
        $query = $builder->select('emp_code, emp_name')->distinct()->get();
        return $query->getResultArray();
    }
    
    public function getUniqueMonths()
    {
        $builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
        $query = $builder->select('month')->distinct()->get();
        return $query->getResultArray();
    }
}
