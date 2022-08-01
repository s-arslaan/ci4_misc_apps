<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Models\Login;
use CodeIgniter\I18n\Time;
use DateTime;

/**
 * @property IncomingRequest $request 
 */

class Auth extends BaseController
{
    public $userModel;
    public $rsaFunction;
    public $session;
    public function __construct()
    {
        $this->userModel = new Users();
        $this->loginModel = new Login();
        $this->session = \Config\Services::session();
        helper('date');
    }

    public function showUsers()
    {

        $users = $this->userModel->getUsers();
        $myTime = Time::now(app_timezone(), 'en_US');

        echo "<pre>";
        echo $myTime . '<br><br>';
        print_r($users);
    }

    public function login()
    {
        if ($this->request->getMethod() == 'post') {

            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            $password = $this->request->getVar('password');
            $curr_time = Time::now(app_timezone(), 'en_US');

            $userdata = $this->loginModel->searchEmail($email);

            if ($userdata) {

                if ($userdata->password === md5($password)) {

                    if ($userdata->status == 1) {

                        $loginInfo = [
                            'unique_id' => $userdata->unique_id,
                            'agent' => $this->getUserAgentInfo(),
                            'platform' => $this->getUserAgentInfo(true),
                            'ip' => $this->request->getIPAddress(),
                            'login_time' => $curr_time
                        ];

                        $la_id = $this->loginModel->saveLoginInfo($loginInfo);
                        if($la_id) {
                            $this->session->set('login_activity_id', $la_id);
                        }

                        $this->session->set('logged_user', $userdata->unique_id);
                        $this->session->set('logged_user_name', $userdata->name);
                        $this->session->setTempdata('success', 'Welcome ' . strtoupper($userdata->name));
                        return redirect()->to(base_url());

                    } else {
                        $this->session->setTempdata('error', 'Please verify your email');
                        return redirect()->to(current_url());
                    }
                } else {
                    $this->session->setTempdata('error', 'Incorrect email or password - pass');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setTempdata('error', 'Incorrect email or password - email');
                return redirect()->to(current_url());
            }
        }

        $data = array(
            'title' => 'Shama | Login',
        );

        return view('login', $data);
    }

    public function register()
    {
        if ($this->request->getMethod() == 'post') {

            $name = htmlentities($this->request->getVar('name'));
            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            // $password = $this->rsaFunction->encrypt($prime1, $prime2, $this->request->getVar('password'));
            $password = md5($this->request->getVar('password'));
            $mobile = $this->request->getVar('mobile');
            $curr_time = Time::now(app_timezone(), 'en_US');
            $unique_id = md5(str_shuffle($name . time()));

            $userdata = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'mobile' => $mobile,
                // 'activation_date' => date('Y-m-d h:i:s'),
                'activation_date' => $curr_time,
                'unique_id' => $unique_id,
            );
            // die(print_r($userdata));

            if ($this->loginModel->searchEmail($email) == false) {

                if ($this->userModel->addUser($userdata)) {
                    // $subject = 'RSA GNU | Account Activation';
                    // $body = "Hi $name,<br>Thanks for creating an account with us. Please activate your account.<a href=\"".base_url()."/auth/activate/$unique_id\" target='_blank'>Activate Now</a>";

                    $this->session->setTempdata('success', 'User Registered');
                    return redirect()->to(current_url());
                } else {
                    $this->session->setTempdata('error', 'Something went wrong');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setTempdata('error', 'User already exists!');
                return redirect()->to(current_url());
            }
        }

        $data = array(
            'title' => 'Shama | Register User',
        );
        return view('register', $data);
    }

    public function activate($unique_id = null)
    {
        $data = [];
        if (!empty($unique_id)) {
            $userdata = $this->userModel->getUserDetails($unique_id);
            // die(print_r($data));
            if ($userdata) {
                if ($this->isLinkValid($userdata->activation_date)) {
                    if ($userdata->status == 0) {
                        if ($this->userModel->updateStatus($unique_id)) {
                            $data['success'] = 'Email verified successfully!';
                        }
                    } else {
                        $data['success'] = 'Email is already verified!';
                    }
                } else {
                    $data['error'] = 'Sorry! Link Expired!';
                }
            } else {
                $data['error'] = 'Invalid Link!';
            }
        } else {
            $data['error'] = 'Sorry! Unable to process request!';
        }
        return view("activate", $data);
    }

    public function logout()
    {
        $curr_time = Time::now(app_timezone(), 'en_US');

        if(session()->has('login_activity_id')) {
            $la_id = session()->get('login_activity_id');
            $this->loginModel->updateLogoutTime($la_id, $curr_time);
        }

        session()->remove('logged_user');
        session()->destroy();
        return redirect()->to("./auth/login");
    }

    public function isLinkValid($regTime)
    {
        $currTime = now();
        $diffTime = (int)$currTime - (int)strtotime($regTime);
        if ($diffTime < 3600) {
            // if time is less than 1 hour
            return true;
        } else {
            return false;
        }
    }

    public function getUserAgentInfo($platform_flag = false)
    {

        $agent = $this->request->getUserAgent();

        if ($agent->isBrowser()) {
            $currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
        } elseif ($agent->isRobot()) {
            $currentAgent = $agent->getRobot();
        } elseif ($agent->isMobile()) {
            $currentAgent = $agent->getMobile();
        } else {
            $currentAgent = 'Unidentified User Agent';
        }

        // $res = array(
        //     'agent' => $currentAgent,
        //     'platform' => 
        // );

        if ($platform_flag)
            return $agent->getPlatform();
        else
            return $currentAgent;
        // echo "<pre>";
        // print_r($res);
    }

    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
