<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\Users;

/**
 * @property IncomingRequest $request 
 */

class Auth extends BaseController
{
    public function profile()
    {
        
    }

    public function _remap($method, $param = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param);
        }
        throw PageNotFoundException::forPageNotFound();
    }
}