<?php


namespace App\Controllers\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Login extends Controller
{
    use ResponseTrait;
    public function index()
    {
        return $this->respondCreated(array('code'=>11));
    }
}