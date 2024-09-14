<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;


class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        if($request->isPost()){
            return 'Handle submitting data';
        }
        
        $this->setLayout('auth');
        return $this->render('register');
    }
}
?>

