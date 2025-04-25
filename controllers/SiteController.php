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

        // $this->setLayout('auth');

        return $this->render('contact', [
            'model' => $contact
        ]);
    }

    public function userDashboard()
    { 
        $this->setLayout('dashboard');
        return $this->render('userdashboard');
    }

    public function userProfile()
    {
        
        $this->setLayout('dashboard');
        return $this->render('userprofile');
    }

    public function adminDashboard(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('admindashboard');
    }

    public function stewardDashboard(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('stewarddashboard');
    }

    public function managerDashboard(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('managerDashboard');
    }

    public function chefdashboard(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('chefdashboard');
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
        $this->setLayout('dashboard');
        return $this->render('dinein');
    }

    public function payment(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('payments');
    }

    public function takeaway_payment(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('takeawaypayments');
    }

    public function otp(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('otp');
    }

    public function cart(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('cart');
    }

    public function menu(Request $request,Response $response)
    {
        $this->setLayout('main');
        return $this->render('menu');
    }

    public function homeMenu(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('homeMenu');
    }

    public function selectBranch(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('selectBranch');
    }

    public function viewUsers(Request $request,Response $response)
    {
        $this->setLayout('main');
        return $this->render('viewUsers');
    }
   
    public function staff(Request $request,Response $response)
    {
        $this->setLayout('main');
        return $this->render('staff');
    }

    public function offer(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('offer');
    }

    public function viewOfferMain(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('offerView');
    }

    //admin
    public function dashboardAdmin(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/admin/dashboard');
    }

    public function staffAdmin(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/admin/staff');
    }

    public function updatemenuAdmin(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/admin/update-menu');
    }

    public function updateoffersAdmin(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/admin/update-offers');
    }

    public function feedbacksAdmin(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/admin/feedbacks');
    }


    //steward
    public function dineInSteward(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/steward/dine-in-orders');
    }
    
    public function takeAwaySteward(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/steward/take-away-orders');
    }


    public function customerarrivalsSteward(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/steward/customer-arrivals');
    }

    public function paymentsSteward(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/steward/customer-payments');
    }

    public function addMeal(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/addMeals');
    }
    
    public function enterpin(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('enterpin');
    }

    public function viewOrderChef(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/chef/view-order');
    }

    public function updateMenuChef(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('/chef/update-menu');
    }


    public function successReservation(Request $request,Response $response)
    {
        $this->setLayout('auth');
        return $this->render('successReservation');
    }

    public function confirmReservation(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('confirmReservation');
    }

    public function takeawayMenu(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('takeawayMenu');
    }

    public function takeawayCart(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('takeawayCart');
    }


    public function menuAccess(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('menuAccess');
    }


    public function unRegMenu(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('UnRegMenu');
    }


    public function stewardMenu(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('stewardMenu');
    }

    public function unRegPayment(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('unRegPayment');
    }

    public function paymentCollection(Request $request,Response $response)
    {
        $this->setLayout('dashboard');
        return $this->render('paymentCollection');
    }

    
}
?>