<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Models\HomeModel;

/**
 * @property IncomingRequest $request 
 */

class Home extends BaseController
{
    public $userModel;
    public function __construct()
    {   
        $this->userModel = new Users();
        $this->homeModel = new HomeModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to(base_url()."/auth/login");
        } else {
            return redirect()->to(base_url()."/home/dashboard");
        }
        
    }
    
    public function dashboard()
    {
        $data = array(
            'title' => 'Shama | Dashboard',
            'users' => $this->userModel->getUsers(),
        );

        return view('dashboard_view', $data);
    }

    public function profile()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        $unique_id = session()->get('logged_user');
        $userdata = $this->userModel->getUserDetails($unique_id);
        
        $data = array(
            'title' => 'Shama | User Profile',
            'user' => $userdata,
        );

        return view('profile', $data);
    }
    
    public function editProfile()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }

        if ($this->request->getMethod() == 'post') {

            if($this->request->getVar('new-pass') !== null) {

                $data = array(
                    'id' => session()->get('logged_user'),
                    'curr_pass' => $this->request->getVar('curr-pass'),
                    'new_pass' => $this->request->getVar('new-pass')
                );

                if($this->userModel->updateUserPassword($data)) {
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

                if($this->userModel->updateUserDetails($data)) {
                    $this->session->setTempdata('success', 'Profile Updated');
                } else {
                    $this->session->setTempdata('error', 'Some Error Occurred');
                }
            }
        }
        else {
            $this->session->setTempdata('error', 'Some Error Occurred');
        }
        return redirect()->to("./home/profile");
    }

    public function loginActivity()
    {
        $data = array(
            'title' => 'Shama | Login Activity',
            'team' => 'shama education',
            // 'userdata' => $this->homeModel->getLoggedinUserData(session()->get('logged_user')),
            'login_info' => $this->homeModel->getLoginActivity()
        );

        return view('login_activity', $data);
    }

    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
