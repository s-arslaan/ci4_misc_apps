<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;
use App\Models\Login;
use ReflectionMethod;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

/**
 * @property IncomingRequest $request 
 */

class Api extends BaseController
{
    use ResponseTrait;
    public $userModel;
    public $loginModel;
    public $apiModel;
    public $session;
    public function __construct()
    {
        $this->userModel = model(Users::class);
        $this->loginModel = model(Login::class);
        $this->apiModel = model(ApiModel::class);
        $this->session = \Config\Services::session();
        helper('date');
    }

    public function beachAlert()
    {
        if ($this->request->getVar('token') != null) {

            if ($this->request->getMethod() == 'post') {

                $data = array(
                    // 'user_id' => $this->request->getVar('user_id', FILTER_DEFAULT),
                    'gToken' => $this->request->getVar('token', FILTER_DEFAULT),
                    'latitude' => $this->request->getVar('latitude', FILTER_DEFAULT),
                    'longitude' => $this->request->getVar('longitude', FILTER_DEFAULT),
                    'address' => $this->request->getVar('address', FILTER_DEFAULT),
                    'ip' => $this->request->getIPAddress(),
                );

                // $user_id = $this->apiModel->storeAlert($data);
                if ($this->apiModel->storeAlert($data)) {
                    $response = array(
                        'status'   => 201,
                        'msg' => 'Alert generated successfully',
                        'success' => true
                    );
                } else {
                    $response = array(
                        'status'   => 500,
                        'msg'    => 'something went wrong!',
                        'success' => false
                    );
                }
            } else {
                $response = array(
                    'status'   => 400,
                    'msg' => 'data not found!',
                    'success' => false
                );
            }
        } else {
            $response = array(
                'status'   => 400,
                'msg'    => 'authentication error!',
                'success' => false
            );
        }

        return $this->respondCreated($response);
    }
    
    public function googleSignIn()
    {
        if ($this->request->getVar('token') != null) {

            if ($this->request->getMethod() == 'post') {
                // 110022754939632693383

                $data = array(
                    // 'user_id' => $this->request->getVar('user_id', FILTER_DEFAULT),
                    'name' => $this->request->getVar('name', FILTER_DEFAULT),
                    'email' => $this->request->getVar('email', FILTER_DEFAULT),
                    'familyName' => $this->request->getVar('familyName', FILTER_DEFAULT),
                    'gToken' => $this->request->getVar('token'),
                );

                $user_id = $this->apiModel->addBeachUser($data);
                if ($user_id) {
                    if($user_id === 1) {
                        $response = array(
                            'status'   => 201,
                            'msg' => 'User Registered Successfully',
                            'success' => true,
                        );
                    } else {
                        $response = array(
                            'status'   => 201,
                            'msg' => 'User Registered Already!',
                            'success' => true,
                        );
                    }
                } else {
                    $response = array(
                        'status'   => 500,
                        'msg'    => 'something went wrong!',
                        'success' => false
                    );
                }
            } else {
                $response = array(
                    'status'   => 400,
                    'msg' => 'data not found!',
                    'success' => false
                );
            }
        } else {
            $response = array(
                'status'   => 400,
                'msg'    => 'Authentication error!',
                'success' => false
            );
        }

        return $this->respondCreated($response);
    }

    public function addBeachUser()
    {
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
