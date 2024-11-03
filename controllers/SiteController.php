<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;
use app\models\Employee;
use app\models\User;

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

    public function userProfile()
    {
        $params = [
            'name' => "Nadun"
        ];
        return $this->render('userProfile', $params);
    }

    public function adminDashboard(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('admindashboard');
    }
}
?>