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

    function uploadLeads(&$reader, &$database)
	{

		$data = $reader->getSheet(0);

		$k = $data->getHighestRow();
		$isFirstRow = TRUE;
		// $i=0;
		$leads = array();

		// for ($i = 1; $i <= $k; $i += 1) {
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

        for ($i = 1; $i <= $k; $i += 1) {
			$j = 1;
			$leads = [];
            echo $k."\n";

			array_push($leads, $this->getCell($data, $i, $j++));

		}
        echo '<pre>';print_r($leads);exit;
		// return true;
		// return $this->storeLeadsIntoDatabase($database, $leads);
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
