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
            return redirect()->to("./auth/login");
        }
        
        $data = array(
            'title' => 'Shama',
            'users' => $this->userModel->getUsers(),
        );

        return view('index_view', $data);
    }

    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}
