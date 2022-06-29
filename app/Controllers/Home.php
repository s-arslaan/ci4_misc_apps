<?php

namespace App\Controllers;
use App\Models\Users;
use App\Models\HomeModel;

class Home extends BaseController
{
    public $userModel;
    public function __construct()
    {   
        $this->userModel = new Users();
        $this->homeModel = new HomeModel();
    }

    public function index()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }
        
        $data = array(
            'title' => 'Shama',
            'team' => 'shama education',
            'users' => $this->userModel->getUsers(),
        );

        return view('index_view', $data);
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
}
