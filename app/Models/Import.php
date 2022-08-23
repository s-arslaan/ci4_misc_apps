<?php

namespace App\Models;

use CodeIgniter\Model;

require ROOTPATH.'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Import extends Model
{
    function getCell(&$worksheet, $row, $col, $default_val = '')
	{
		// $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
		// $row += 1; // we use 0-based, PHPExcel used 1-based row index
		return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
	}

	protected function getRowsList($final_row, $initial)
	{
		$rows = [];

		$i = $initial;

		while ($i <= $final_row) {
			array_push($rows,$i);
			$i+=10;
		}
		return $rows;
	}

    protected function isValidFileFormat(&$reader)
	{
		$data = $reader->getSheet(0);
		$final_row = $data->getHighestRow();

		if($final_row%10 != 0)
			return false;

		// get row indexes
		$month_rows = $this->getRowsList($final_row, 1);
		$cnt_rows = $this->getRowsList($final_row, 2);

		for ($i = 1; $i <= $final_row; $i += 1) {

			if(in_array($i,$month_rows)) {
				if($this->getCell($data, $i, 3) !== 'physiotherapy')
					return false;
				if($this->getCell($data, $i, 16) !== 'Shama institute of medical sciences')
					return false;
				$month = $this->getCell($data, $i, 30);
			}
			if(in_array($i,$cnt_rows)) {
				$code = $this->getCell($data, $i, 3);
				$name = $this->getCell($data, $i, 9);

				if(!$this->isValidEntry($code, $name, $month)){
					// echo '<pre>'.$code.' '.$name.' '.$month;exit;
					return false;
				}
			}

		}
		return true;
	}

    function uploadLeads(&$reader)
	{

		$data = $reader->getSheet(0);
		$final_row = $data->getHighestRow();
		
		// get row indexes
		$month_rows = $this->getRowsList($final_row, 1);
		$cnt_rows = $this->getRowsList($final_row, 2);
		$in_rows = $this->getRowsList($final_row, 5);
		$out_rows = $this->getRowsList($final_row, 6);
		$status_rows = $this->getRowsList($final_row, 10);

		$leads = array();
		$cnt = 0;

        for ($i = 1; $i <= $final_row; $i += 1) {

			if(in_array($i,$month_rows)) {
				$leads[$cnt]['dept'] = $this->getCell($data, $i, 3);
				$leads[$cnt]['month'] = $this->getCell($data, $i, 30);
			}
			if(in_array($i,$cnt_rows)) {
				$leads[$cnt]['emp_code'] = $this->getCell($data, $i, 3);
				$leads[$cnt]['emp_name'] = $this->getCell($data, $i, 9);
				$leads[$cnt]['present_days'] = $this->getCell($data, $i, 18);
				$leads[$cnt]['absent_days'] = $this->getCell($data, $i, 23);
			}
			if(in_array($i,$in_rows)) {
				$leads[$cnt]['in_timings'] = [];
				for ($j=2; $j <= 32; $j++) { 
					$time = $this->getCell($data, $i, $j);
					if(stripos($leads[$cnt]['month'],'sep') || stripos($leads[$cnt]['month'],'apr') || stripos($leads[$cnt]['month'],'jun') || stripos($leads[$cnt]['month'],'nov')) {
						$time = 'na';
					}
					array_push($leads[$cnt]['in_timings'],$time);
				}
			}
			if(in_array($i,$out_rows)) {
				$leads[$cnt]['out_timings'] = [];
				for ($j=2; $j <= 32; $j++) {
					array_push($leads[$cnt]['out_timings'],$this->getCell($data, $i, $j));
				}
			}
			if(in_array($i,$status_rows)) {
				$leads[$cnt]['status'] = [];
				for ($j=2; $j <= 32; $j++) {
					array_push($leads[$cnt]['status'],$this->getCell($data, $i, $j));
				}
				$cnt++;
			}

		}

		$ok = $this->storeRowsDB($leads);
		
		if(!$ok) {
			return false;
		}
		return true;

		// echo '<pre>';print_r($leads);exit;
        // echo '<pre>';print_r($month_rows);print_r($cnt_rows);print_r($in_rows);print_r($out_rows);print_r($status_rows);exit;
		// return $this->storeLeadsIntoDatabase($database, $leads);
	}

	protected function storeRowsDB($data)
	{	
		$batch = array();
		$each_row = array();
		$count = 0;

		foreach ($data as $person) {

			$arr_count=0;
			// while($arr_count < 3) {
			for ($arr_count=0; $arr_count < 3; $arr_count++) { 

				$each_row = [];
				$each_row['emp_code'] = htmlentities($person['emp_code']);
				$each_row['emp_name'] = htmlentities(strtolower($person['emp_name']));
				$each_row['entry_type'] = $arr_count;
				$each_row['month'] = htmlentities(strtolower($person['month']));

				// setting the timing array
				$arr = [];
				if($arr_count === 0)
					$arr = $person['in_timings'];
				elseif($arr_count === 1)
					$arr = $person['out_timings'];
				elseif($arr_count === 2)
					$arr = $person['status'];

				if(is_array($arr)) {
					foreach ($arr as $key => $value) {
						$t = 'date_'.($key+1);
						$each_row[$t] = htmlentities($value);
					}
				}

				$each_row['present_days'] = htmlentities($person['present_days']);
				$each_row['absent_days'] = htmlentities($person['absent_days']);

				$batch[] = $each_row;
				$count++;
				// $builder->insert($each_row);
			}
		}
		// echo '<pre>';print_r($batch);echo count($batch);exit;

		$builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
		$builder->insertBatch($batch);
		if ($this->db->affectedRows() == $count) {
			return True;
		} else {
			return False;
		}
	}

    public function upload($filename, $checkValid = false)
	{

		try {

			// parse uploaded spreadsheet file
			$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
			$objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$reader = $objReader->load($filename);

			if($checkValid) {
				return $this->isValidFileFormat($reader);
			}
			else {
				$ok = $this->uploadLeads($reader);
	
				if (!$ok) {
					return FALSE;
				}
				return $ok;
			}


		} catch (\Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			// $this->session->set('import_error', array('errstr' => $errstr, 'errno' => $errno, 'errfile' => $errfile, 'errline' => $errline));
            // log_message('error','PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			return FALSE;
			// die($e);
		}
	}

	protected function isValidEntry($code, $name, $month)
	{
		$where_arr = ['emp_code' => $code, 'emp_name' => $name, 'month' => $month];

		$builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
		$builder->select('emp_code, emp_name, month')->where($where_arr);
        $res = $builder->get();

		if (count($res->getResultArray()) == 3) {
		// echo '<pre>';print_r($res->getResultArray());exit;

            return false;
        } else {
            return true;
        }

	}
}
