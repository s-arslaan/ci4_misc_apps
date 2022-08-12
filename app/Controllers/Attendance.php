<?php

namespace App\Controllers;
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
        $this->userModel = new Users();
        $this->homeModel = new HomeModel();
        $this->importModel = new Import();
        $this->session = \Config\Services::session();
    }

    public function index()
    {   
        if(!session()->has('logged_user')) {
            return redirect()->to("./auth/login");
        }
        
        $data = array(
            'title' => 'Shama | Attendance'
        );

        return view('attendance_view', $data);
    }

    public function import_attendance()
    {
        if ($this->request->getMethod() == 'post') {
			if ($this->request->getFile('atnd_file') !== null) {

				$file = $this->request->getFile('atnd_file');

                $this->importModel->upload($file);
			}
		} else {
            die('noooooooo');
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
