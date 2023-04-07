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

        if (count($storedUser) > 0) {
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

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    function haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
