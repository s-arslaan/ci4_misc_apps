<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\AttendanceModel;
use App\Models\UsersModel;
use App\Models\HomeModel;
use ReflectionMethod;

/**
 * @property IncomingRequest $request 
 */

class Home extends BaseController
{
    public $userModel;
    public $homeModel;
    public $attendanceModel;
    public $session;
    public function __construct()
    {
        // $this->userModel = new Users();
        // $this->homeModel = new HomeModel();
        // $this->attendanceModel = new AttendanceModel();
        $this->userModel = model(UsersModel::class);
        $this->homeModel = model(HomeModel::class);
        $this->attendanceModel = model(AttendanceModel::class);
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to(base_url() . "/auth/login");
        } else {
            return redirect()->to(base_url() . "/home/dashboard");
        }
    }

    public function dashboard()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        $data = array(
            'title' => APP_NAME.' | Dashboard',
            'alerts' => $this->userModel->getAlerts(),
            'successful_rescues_count' => $this->homeModel->getSuccessfulRescueCount(),
            'todays_alerts' => $this->homeModel->getTodaysAlertCount(),
            'maps_api_key' => getenv('custom.maps_api_key'),
        );

        // echo '<pre>';print_r($data);exit;
        // dd($data);
        return view('dashboard_view', $data);
    }

    public function profile()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        $unique_id = session()->get('logged_user');
        $userdata = $this->userModel->getUserDetails($unique_id);

        $data = array(
            'title' => APP_NAME.' | User Profile',
            'user' => $userdata,
        );

        return view('profile', $data);
    }

    public function changeRescueStatus($alert_id)
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        if ($this->homeModel->changeRescueStatus($alert_id)) {
            $this->session->setTempdata('success', 'Status Changed');
        } else {
            $this->session->setTempdata('error', 'Something Went Wrong!');
        }

        return redirect()->to("./home/dashboard");
    }
    
    public function addRemarks($alert_id)
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        $remarks = $this->request->getVar('remarks',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // dd($remarks);

        if ($this->homeModel->addRemarks($remarks, $alert_id)) {
            $this->session->setTempdata('success', 'Remarks Added');
        } else {
            $this->session->setTempdata('error', 'Something Went Wrong!');
        }

        return redirect()->to("./home/dashboard");
    }

    public function editProfile()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        if ($this->request->getMethod() == 'post') {

            if ($this->request->getVar('new-pass') !== null) {

                $data = array(
                    'id' => session()->get('logged_user'),
                    'curr_pass' => $this->request->getVar('curr-pass'),
                    'new_pass' => $this->request->getVar('new-pass')
                );

                if ($this->userModel->updateUserPassword($data)) {
                    $this->session->setTempdata('success', 'Password Changed');
                } else {
                    $this->session->setTempdata('error', 'Invalid Current Password!');
                }
            } else {
                $data = array(
                    'id' => session()->get('logged_user'),
                    'name' => $this->request->getVar('edit-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                    'mobile' => $this->request->getVar('edit-mobile', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                );

                if ($this->userModel->updateUserDetails($data)) {
                    $this->session->setTempdata('success', 'Profile Updated');
                } else {
                    $this->session->setTempdata('error', 'Some Error Occurred');
                }
            }
        } else {
            $this->session->setTempdata('error', 'Some Error Occurred');
        }
        return redirect()->to("./home/profile");
    }

    public function beachControls()
    {
        if (!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        $data = array(
            'title' => APP_NAME.' | Beach Controls',
            'beaches' => $this->homeModel->getBeaches(),
        );
    }

    public function loginActivity()
    {
        $data = array(
            'title' => APP_NAME.' | Login Activity',
            'team' => 'App ',
            // 'userdata' => $this->homeModel->getLoggedinUserData(session()->get('logged_user')),
            'login_info' => $this->homeModel->getLoginActivity()
        );

        return view('login_activity', $data);
    }

    // remap function for checking if method exists with accepted parameter
    public function _remap($method, $param0 = null, $param1 = null, $param2 = null)
    {
        if (method_exists($this, $method)) {
            if (isset($param2))
                $temp = $param0 . ',' . $param1 . ',' . $param2;
            else if (isset($param1))
                $temp = $param0 . ',' . $param1;
            else if (isset($param0))
                $temp = $param0;
            else
                $temp = '';

            $params = [];
            if ($temp !== '')
                $params = explode(',', $temp);
            // echo '<pre>';print_r($method);echo '<br>';print_r($params);exit;

            $existing = new ReflectionMethod($this, $method);
            $existing_params = $existing->getParameters();

            if (count($existing_params) == count($params))
                return call_user_func_array(array($this, $method), $params);
            else
                throw PageNotFoundException::forPageNotFound();
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
}
