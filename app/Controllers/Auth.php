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
    public $loginModel;
    public $session;
    public function __construct()
    {
        $this->userModel = model(Users::class);
        $this->loginModel = model(Login::class);
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
            // echo'<pre>';print_r($this->loginModel);exit;

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
                    // $subject = 'Account Activation';
                    // $body = "Hi $name,<br>Thanks for creating an account with us. Please activate your account.<a href=\"".base_url()."/auth/activate/$unique_id\" target='_blank'>Activate Now</a>";
                    // email to be sent

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

    public function forgotPassword()
    {
        if ($this->request->getMethod() == 'post') {
            
            $email = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
            $userdata = $this->loginModel->searchEmail($email);
            if (!empty($userdata)) {
                $curr_time = Time::now(app_timezone(), 'en_US');
                if($this->userModel->updatedAt($userdata->unique_id, $curr_time)) {

                    // email to be sent
                    $link = base_url().'/auth/resetPassword/'.$userdata->unique_id;

                    $this->session->setTempdata('success', 'Reset link sent to email!');
                    return redirect()->to(current_url());
                }
                else {
                    $this->session->setTempdata('error', 'Sorry! Link Expired');
                    return redirect()->to(current_url());
                }
            } else {
                $this->session->setTempdata('error', 'User not found!');
                return redirect()->to(current_url());
            }
        }

        $data = array(
            'title' => 'Shama | Forgot Password',
        );
        return view('forgot_view', $data);
    }

    public function resetPassword($token = null)
    {   
        if(!empty($token)) {
            $userdata = $this->userModel->getUserDetails($token);
            if(!empty($userdata)) {
                if($this->isLinkValid($userdata->updated_at)) {

                    if ($this->request->getMethod() == 'post') {

                        if($this->request->getVar('password') !== null) {

                            $data = array(
                                'id' => $token,
                                'new_pass' => $this->request->getVar('password')
                            );
            
                            if($this->userModel->resetPassword($data)) {
                                $this->session->setTempdata('success', 'Password Changed');
                                return redirect()->to(base_url());
                            } else {
                                $this->session->setTempdata('error', 'Unable to update Password!');
                                return redirect()->to(base_url());
                            }
            
                        }
                    }
                }
                else {
                    die('Sorry! Link Expired');
                }

            }
            else {
                die('Invalid Link!');
            }
        }
        else {
            die('Invalid Link!');
        }

        $data = array(
            'title' => 'Shama | Reset Password',
        );
        return view('resetPassword_view', $data);

    }

    protected function isLinkValid($regTime)
    {
        $currTime = new Time('now');
        $regTime =  Time::parse($regTime);
        $diffTime = $regTime->difference($currTime);
        // die(gettype($diffTime->minutes));
        // die($diffTime->humanize());

        if ($diffTime->minutes < 15) {
            // if time is less than 15 mins
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

    // public function _remap($method, $param = null)
    // {
    //     if (method_exists($this, $method)) {
    //         return $this->$method($param);
    //     }
    //     throw PageNotFoundException::forPageNotFound();
    // }
    
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
}
