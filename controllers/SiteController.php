<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => "Nadun"
        ];
        return $this->render('home', $params);
    }

    public function contact(Request $request,Response $response)
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thanks for contacting us.');
                return $response->redirect('/contact');
            }
        }

        $this->setLayout('auth');

        return $this->render('contact', [
            'model' => $contact
        ]);
    }

    public function userDashboard()
    {
        
        $this->setLayout('profile');
        return $this->render('userdashboard');
    }

    public function userProfile()
    {
        
        $this->setLayout('profile');
        return $this->render('userprofile');
    }

    public function adminDashboard(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('admindashboard');
    }

    public function chefDashboard(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('chefdashboard');
    }

    public function stewardDashboard(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('stewarddashboard');
    }


    public function about(Request $request,Response $response)
    {
        // $this->setLayout('auth');
        return $this->render('about');
    }

    public function cancelReserve(Request $request,Response $response)
    {
        // $this->setLayout('auth');
        return $this->render('cancelReserve');
    }

    public function dinein(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('dinein');
    }

    public function payment(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('payments');
    }
   
}
?>