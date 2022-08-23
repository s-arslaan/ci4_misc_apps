<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Models\HomeModel;
use App\Models\Import;
use ReflectionMethod;

/**
 * @property IncomingRequest $request 
 */

class Attendance extends BaseController
{
    public $userModel;
    public $homeModel;
    public $importModel;
    public $attendanceModel;
    public $session;
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

    // public function _remap($method, $params = array())
    // {
    //     if (method_exists($this, $method))
    //     {
    //         return call_user_func_array(array($this, $method), $params);
    //     }
    //     else {
    //         throw PageNotFoundException::forPageNotFound();
    //     }
        
    // }
    
    // remap function for checking if method exists with accepted parameter
    public function _remap($method, $param0 = null, $param1 = null, $param2 = null)
    {
        if (method_exists($this, $method))
        {
            if(isset($param2))
                $temp = $param0.','.$param1.','.$param2;
            else if(isset($param1))
                $temp = $param0.','.$param1;
            else if(isset($param0))
                $temp = $param0;
            else
                $temp = '';

            $params = [];
            if($temp !== '')
                $params = explode(',',$temp);
            // echo '<pre>';print_r($method);echo '<br>';print_r($params);exit;

            $existing = new ReflectionMethod($this,$method);
            $existing_params = $existing->getParameters();

            if(count($existing_params) == count($params))
                return call_user_func_array(array($this, $method), $params);
            else
                throw PageNotFoundException::forPageNotFound();
        }
        else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
    
}
