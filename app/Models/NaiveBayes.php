<?php

namespace App\Models;

use CodeIgniter\Model;

class NaiveBayes extends Model
{
    // $beats = array(119, 118, 113, 134, 135, 123, 100, 111, 110, 115, 119, 117);

    public function part1($beats)
    {
        $part1 = array_slice($beats, -6, 6);
        $part1_count_yes = 0;
        $part1_count_no = 0;

        for ($i = 0; $i < count($part1); $i++) {
            if ($part1[$i] > 120 or ($part1[$i] < 60)) {
                $part1_count_yes++;
            } elseif ($part1[$i] < 120) {
                $part1_count_no++;
            }
        }

        $part1_probability_yes = $part1_count_yes / count($part1);
        $part1_probability_no = $part1_count_no / count($part1);

        if ($part1_probability_yes > $part1_probability_no) {
            return true;
        } elseif ($part1_probability_yes == $part1_probability_no) {
            $this->part1_1($beats);
        } elseif ($part1_probability_yes != 0) {
            return false;
        } else {
            $this->part2($beats);
        }
    }

    private function part1_1($beats)
    {
        $part1 = array_slice($beats, -6, 6);
        $part1_1 = array_slice($part1, 3, 3);
        $part1_1_count_yes = 0;
        $part1_1_count_no = 0;

        for ($i = 0; $i < count($part1_1); $i++) {
            if ($part1_1[$i] > 120 or ($part1_1[$i] < 60)) {
                $part1_1_count_yes++;
            } elseif ($part1_1[$i] < 120) {
                $part1_1_count_no++;
            }
        }

        $part1_1_probability_yes = $part1_1_count_yes / count($part1_1);
        $part1_1_probability_no = $part1_1_count_no / count($part1_1);

        if ($part1_1_probability_yes > $part1_1_probability_no) {
            return true;
        } else {
            $this->part1_2($beats);
        }
    }

    private function part1_2($beats)
    {
        $part1 = array_slice($beats, -6, 6);
        $part1_2 = array_slice($part1, 0, 3);
        $part1_2_count_yes = 0;
        $part1_2_count_no = 0;

        for ($i = 0; $i < count($part1_2); $i++) {
            if ($part1_2[$i] > 120 or $part1_2[$i] < 60) {
                $part1_2_count_yes++;
            } elseif ($part1_2[$i] < 120) {
                $part1_2_count_no++;
            }
        }

        $part1_2_probability_yes = $part1_2_count_yes / count($part1_2);
        $part1_2_probability_no = $part1_2_count_no / count($part1_2);

        if ($part1_2_probability_yes > $part1_2_probability_no) {
            return true;
        } else {
            $this->part2($beats);
        }
    }

    private function part2($beats)
    {
        $part2 = array_slice($beats, -12, 6);
        $part2_count_yes = 0;
        $part2_count_no = 0;

        for ($i = 0; $i < count($part2); $i++) {
            if ($part2[$i] > 120 or ($part2[$i] < 60)) {
                $part2_count_yes++;
            } elseif ($part2[$i] < 120) {
                $part2_count_no++;
            }
        }

        $part2_probability_yes = $part2_count_yes / count($part2);
        $part2_probability_no = $part2_count_no / count($part2);

        if ($part2_probability_yes > $part2_probability_no) {
            return true;
        } elseif ($part2_probability_yes == $part2_probability_no) {
            $this->part2_1($beats);
        } else {
            return false;
        }
    }

    private function part2_1($beats)
    {
        $part2 = array_slice($beats, -12, 6);
        $part2_1 = array_slice($part2, 3, 3);
        $part2_1_count_yes = 0;
        $part2_1_count_no = 0;

        for ($i = 0; $i < count($part2_1); $i++) {
            if ($part2_1[$i] > 120 or ($part2_1[$i] < 60)) {
                $part2_1_count_yes++;
            } elseif ($part2_1[$i] < 120) {
                $part2_1_count_no++;
            }
        }

        $part2_1_probability_yes = $part2_1_count_yes / count($part2_1);
        $part2_1_probability_no = $part2_1_count_no / count($part2_1);

        if ($part2_1_probability_yes > $part2_1_probability_no) {
            return true;
        } else {
            $this->part2_2($beats);
        }
    }

    private function part2_2($beats)
    {
        $part2 = array_slice($beats, -12, 6);
        $part2_2 = array_slice($part2, 0, 3);
        $part2_2_count_yes = 0;
        $part2_2_count_no = 0;

        for ($i = 0; $i < count($part2_2); $i++) {
            if ($part2_2[$i] > 120 or $part2_2[$i] < 60) {
                $part2_2_count_yes++;
            } elseif ($part2_2[$i] < 120) {
                $part2_2_count_no++;
            }
        }

        $part2_2_probability_yes = $part2_2_count_yes / count($part2_2);
        $part2_2_probability_no = $part2_2_count_no / count($part2_2);

        if ($part2_2_probability_yes > $part2_2_probability_no) {
            return true;
        } else {
            return false;
        }
    }
}
