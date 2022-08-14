<?php

namespace App\Models;

use CodeIgniter\Model;

require 'vendor/autoload.php';
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

		while ($i < $final_row) {
			array_push($rows,$i);
			$i+=10;
		}
		return $rows;
	}

    function uploadLeads(&$reader, &$database)
	{

		$data = $reader->getSheet(0);

		$final_row = $data->getHighestRow();
		$isFirstRow = TRUE;
		// $i=0;

		// for ($i = 1; $i <= $final_row; $i += 1) {
		// 	$lead = array();

		// 	$this->error = array();

		// 	$j = 2;

		// 	if ($isFirstRow) {
		// 		$isFirstRow = FALSE;
		// 		continue;
		// 	}
		// 	$Lead_Owner = $this->getCell($data, $i, $j++);

		// 	$Lead_Owner = htmlentities($Lead_Owner, ENT_QUOTES, $this->detect_encoding($Lead_Owner));

		// 	$Company_name = $this->getCell($data, $i, $j++);
		// 	$Company_name = htmlentities($Company_name, ENT_QUOTES, $this->detect_encoding($Company_name));

		// 	$Company_Address_1	= $this->getCell($data, $i, $j++);
		// 	$Company_Address_1	= htmlentities($Company_Address_1, ENT_QUOTES, $this->detect_encoding($Company_Address_1));

		// 	$Company_Address_2 = $this->getCell($data, $i, $j++);
		// 	$Company_Address_2	= htmlentities($Company_Address_2, ENT_QUOTES, $this->detect_encoding($Company_Address_2));

		// 	$City	= $this->getCell($data, $i, $j++);
		// 	$City	= htmlentities($City, ENT_QUOTES, $this->detect_encoding($City));

		// 	$Postcode	= $this->getCell($data, $i, $j++);
		// 	$Postcode	= htmlentities($Postcode, ENT_QUOTES, $this->detect_encoding($Postcode));

		// 	$state	= $this->getCell($data, $i, $j++);
		// 	$state	= htmlentities($state, ENT_QUOTES, $this->detect_encoding($state));

		// 	$website	= $this->getCell($data, $i, $j++);
		// 	$website	= htmlentities($website, ENT_QUOTES, $this->detect_encoding($website));

		// 	$Contact_Person_Name	= $this->getCell($data, $i, $j++);
		// 	$Contact_Person_Name	= htmlentities($Contact_Person_Name, ENT_QUOTES, $this->detect_encoding($Contact_Person_Name));

		// 	$Designation	= $this->getCell($data, $i, $j++);
		// 	$Designation	= htmlentities($Designation, ENT_QUOTES, $this->detect_encoding($Designation));

		// 	$Mobile	= $this->getCell($data, $i, $j++);
		// 	$Mobile	= htmlentities($Mobile, ENT_QUOTES, $this->detect_encoding($Mobile));

		// 	$Phone	= $this->getCell($data, $i, $j++);
		// 	$Phone	= htmlentities($Phone, ENT_QUOTES, $this->detect_encoding($Phone));

		// 	$Email	= $this->getCell($data, $i, $j++);
		// 	$Email	= htmlentities($Email, ENT_QUOTES, $this->detect_encoding($Email));

		// 	$Estimated_Value	= $this->getCell($data, $i, $j++);
		// 	$Estimated_Value	= htmlentities($Estimated_Value, ENT_QUOTES, $this->detect_encoding($Estimated_Value));

		// 	$Lead_Type	= $this->getCell($data, $i, $j++);
		// 	$Lead_Type	= htmlentities($Lead_Type, ENT_QUOTES, $this->detect_encoding($Lead_Type));

		// 	$Lead_Status	= $this->getCell($data, $i, $j++);
		// 	$Lead_Status	= htmlentities($Lead_Status, ENT_QUOTES, $this->detect_encoding($Lead_Status));

		// 	$Lead_Stage	= $this->getCell($data, $i, $j++);
		// 	$Lead_Stage	= htmlentities($Lead_Stage, ENT_QUOTES, $this->detect_encoding($Lead_Stage));

		// 	$Lead_Creator	= $this->getCell($data, $i, $j++);
		// 	$Lead_Creator	= htmlentities($Lead_Creator, ENT_QUOTES, $this->detect_encoding($Lead_Creator));

		// 	$Follow_up_date	= $this->getCell($data, $i, $j++);
		// 	$Follow_up_date	= htmlentities($Follow_up_date, ENT_QUOTES, $this->detect_encoding($Follow_up_date));

		// 	$Expected_closing_date	= $this->getCell($data, $i, $j++);
		// 	$Expected_closing_date	= htmlentities($Expected_closing_date, ENT_QUOTES, $this->detect_encoding($Expected_closing_date));

		// 	$Actual_closed_date	= $this->getCell($data, $i, $j++);
		// 	$Actual_closed_date	= htmlentities($Actual_closed_date, ENT_QUOTES, $this->detect_encoding($Actual_closed_date));

		// 	$Date_Added	= $this->getCell($data, $i, $j++);
		// 	$Date_Added	= htmlentities($Date_Added, ENT_QUOTES, $this->detect_encoding($Date_Added));

		// 	$Date_Modified	= $this->getCell($data, $i, $j++);
		// 	$Date_Modified	= htmlentities($Date_Modified, ENT_QUOTES, $this->detect_encoding($Date_Modified));

		// 	$Status_Comment	= $this->getCell($data, $i, $j++);
		// 	$Status_Comment	= htmlentities($Status_Comment, ENT_QUOTES, $this->detect_encoding($Status_Comment));

		// 	$Lead_History = $this->getCell($data, $i, $j++);
		// 	// $Lead_History= htmlentities( $product_id, ENT_QUOTES, $this->detect_encoding($Lead_History) );

		// 	$Lead_History = htmlentities($Lead_History, ENT_QUOTES, $this->detect_encoding($Lead_History));

		// 	$lead[] = array(
		// 		'lead_id'	=> '',
		// 		'lead_owner' => $Lead_Owner,
		// 		'company_name' => $Company_name,
		// 		'company_address_1' => $Company_Address_1,
		// 		'company_address_2' => $Company_Address_2,
		// 		'city' => $City,
		// 		'postcode' => $Postcode,
		// 		'state' => $state,
		// 		'website' => $website,
		// 		'contact_person_name' => $Contact_Person_Name,
		// 		'designation' => $Designation,
		// 		'mobile' => $Mobile,
		// 		'phone' => $Phone,
		// 		'email' => $Email,
		// 		'estimated_value' => $Estimated_Value,
		// 		'lead_type' => $Lead_Type,
		// 		'lead_status' => $Lead_Status,
		// 		'lead_stage' => $Lead_Stage,
		// 		'lead_creator' => $Lead_Creator,
		// 		'follow_up_date' => $Follow_up_date,
		// 		'expected_closing_date' => $Expected_closing_date,
		// 		'actual_closed_date' => $Actual_closed_date,
		// 		'date_added' => $Date_Added,
		// 		'date_modified' => $Date_Modified,
		// 		'status_comment' => $Status_Comment,
		// 		'lead_history' => $Lead_History
		// 	);
		// 	$leads[] = $lead;
		// 	// $this->model_sale_lead->addLead($lead);
		// }
		
		// get row indexes
		$month_rows = $this->getRowsList($final_row, 1);
		$cnt_rows = $this->getRowsList($final_row, 2);
		$in_rows = $this->getRowsList($final_row, 5);
		$out_rows = $this->getRowsList($final_row, 6);
		$status_rows = $this->getRowsList($final_row, 10);
		
		$month_30 = ['sep','apr','jun','nov'];

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
		$builder = $this->db->table($this->DBPrefix . 'physiotherapy_attendance');
		$batch = array();
		$count = 0;

		foreach ($data as $person) {
			$each_row = [];

			$each_row['emp_code'] = htmlentities($person['emp_code']);
			$each_row['emp_name'] = htmlentities(strtolower($person['emp_name']));
			$each_row['entry_type'] = 0;
			$each_row['month'] = htmlentities(strtolower($person['month']));

			foreach ($person['in_timings'] as $key => $value) {
				$t = 'date_'.($key+1);
				$each_row[$t] = htmlentities($value);
			}

			$each_row['present_days'] = htmlentities($person['present_days']);
			$each_row['absent_days'] = htmlentities($person['absent_days']);

			$batch[] = $each_row;
			$count++;
			// $builder->insert($each_row);
		}
		$builder->insertBatch($batch);
		if ($this->db->affectedRows() == $count) {
            return True;
        } else {
            return False;
        }
		// return true;
	}

    public function upload($filename)
	{

		try {
			$database = &$this->db;


			// parse uploaded spreadsheet file
			$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
			$objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$reader = $objReader->load($filename);

			$ok = $this->uploadLeads($reader, $database);

			if (!$ok) {
				return FALSE;
			}
			return $ok;

		} catch (\Exception $e) {
			$errstr = $e->getMessage();
			$errline = $e->getLine();
			$errfile = $e->getFile();
			$errno = $e->getCode();
			$this->session->data['export_error'] = array('errstr' => $errstr, 'errno' => $errno, 'errfile' => $errfile, 'errline' => $errline);
            log_message('error','PHP ' . get_class($e) . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
			return FALSE;
		}
	}
}
