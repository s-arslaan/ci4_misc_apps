<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\UsersModel;
use App\Models\HomeModel;
use App\Models\Import;
use ReflectionMethod;

/**
 * @property IncomingRequest $request 
 */

class Users extends BaseController
{
    public $userModel;
    public $homeModel;
    public $importModel;
    public $attendanceModel;
    public $session;
    public function __construct()
    {   
        $this->userModel = model(UsersModel::class);
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

        // dd($_SESSION);

        $data = array(
            'title' => 'Beach App | Web Users',
            'users' => $this->userModel->getWebUsers()
        );
        
        return view('users_view', $data);
    }
    
    public function beachUsers()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        // dd($_SESSION);

        $data = array(
            'title' => 'Beach App | Beach Users',
            'users' => $this->userModel->getBeachUsers()
        );
        
        return view('beachUsers_view', $data);
    }

    public function timings()
    {
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        return view('timings_view', ['title' => 'App | Timings']);
    }
    
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

    public function delete_user($unique_id)
    {
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        if($this->userModel->deactivate_web_user($unique_id)) {
            $this->session->setTempdata('success', 'User deleted successfully!');
            return redirect()->to("./users");
        } else {
            $this->session->setTempdata('error', 'Somethhing went wrong');
        }
    }
}




