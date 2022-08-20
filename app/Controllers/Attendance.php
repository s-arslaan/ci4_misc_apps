<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Models\HomeModel;
use App\Models\Import;

/**
 * @property IncomingRequest $request 
 */

class Attendance extends BaseController
{
    public $userModel;
    public function __construct()
    {   
        $this->userModel = model(Users::class);
        $this->homeModel = model(HomeModel::class);
        $this->importModel = model(Import::class);
        $this->attendanceModel = model(AttendanceModel::class);
        $this->session = \Config\Services::session();
    }

    public function index()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }
        
        return view('attendance_view', ['title' => 'Shama | Attendance']);
    }
    
    public function getAttendance($type)
    {
        if(is_numeric($type)) {
            $attendance = $this->attendanceModel->fetchAttendance($type);
        } else {
            $attendance = [];
        }

        // echo '<pre>';print_r($attendance);exit;
        header('Content-Type: application/json');
        return json_encode( $attendance );
    }

    public function timings()
    {
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        return view('timings_view', ['title' => 'Shama | Timings']);
    }

    public function import_attendance()
    {
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }
        
        if ($this->request->getMethod() == 'post') {
			if ($this->request->getFile('atnd_file') !== null) {

				$file = $this->request->getFile('atnd_file');

                $type = $file->getMimeType();
                $size = $file->getSize();

                if($type == 'application/vnd.ms-excel' || $type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    if($this->importModel->upload($file, true)) {
                        if($size <= 5000000) {
                            // size less than 5 MB
                            if($this->importModel->upload($file)){
                                $this->session->setTempdata('success', 'Upload Successful!');
                                return redirect()->to(base_url().'/attendance');
                            } else {
                                $this->session->setTempdata('error', 'Something went wrong!');
                                return redirect()->to(base_url().'/attendance');
                            }
    
                        } else {
                            $this->session->setTempdata('error', 'File size should be less than 5 MB!');
                            return redirect()->to(base_url().'/attendance');
                        }
                    } else {
                        $this->session->setTempdata('error', 'Invalid File Format!');
                        return redirect()->to(base_url().'/attendance');
                    }
                } else {
                    $this->session->setTempdata('error', 'Invalid File!');
                    return redirect()->to(base_url().'/attendance');
                }
			}
		} else {
            $this->session->setTempdata('error', 'Something went wrong!');
            return redirect()->to(base_url().'/attendance');
        }
    }

    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
