<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginForm;
use app\core\middlewares\AuthMiddleware;
use app\core\SendMail;



class AuthController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['userProfile']));//access array
    }


    public function login(Request $request, Response $response)
{
    $loginForm = new LoginForm();
    $user = new User();

    if ($request->isPost()) {
        $loginForm->loadData($request->getBody());

        $email = $loginForm->email;
        $mobile_number = $loginForm->mobile_number;

        $user = User::findOne(['email' => $email, 'mobile_number' => $mobile_number]);

        if ($user) {
            // Check the user's position
            if ($user->position !== 'customer' && !$loginForm->password) {
                // Return the user's position if not a customer
                
                $this->setLayout('auth');
                return $this->render('login', [
                    'model' => $loginForm,
                    'error' => $user->position // Pass the position as an error
                ]);
            }else if ($user->position !== 'customer' && $loginForm->password) {
                // Proceed with login if the user is a customer
                if ($loginForm->validate() && $loginForm->login()) {
                    $response->redirect('/');
                    return;
                    
                }
                $this->setLayout('auth');
                    return $this->render('login', [
                        'model' => $loginForm
                    ]);

                
            }
        }

        // error_log("User found: " . print_r($loginForm, true));
        // exit;
        
        // Proceed with login if the user is a customer
        if ($loginForm->validate() && $loginForm->login()) {
            $response->redirect('/');
            return;
        }
    }

    $this->setLayout('auth');
    return $this->render('login', [
        'model' => $loginForm
    ]);
}




    public function register(Request $request, Response $response)
    {
        $user = new User();

        if ($request->isPost()) {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->save()) {
                if (Application::$app->login($user)) {
                   
                    $response->redirect('/');
                    return;
                } else {
                    // Debugging statement
                    echo "Failed to log in the user.";
                }
            }
        }

        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile()
    {
        
        return $this->render('profile');
    }

    public function reservationNumberGenerator()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['reservation_name'];
            $email = $_POST['email'];
            $randomNumber = $_GET['random'];

            // var_dump($randomNumber);
            // exit;

            // Ensure SendMail is initialized
            if (!isset(SendMail::$sendmail)) {
                new SendMail();
            }
        
            SendMail::$sendmail->sendMail($email, $name, $randomNumber);

        }

    }



    public function contactus()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = $_POST['subject'];
            $email = $_POST['email'];
            $body = $_POST['body'];

            // var_dump($randomNumber);
            // exit;

            // Ensure SendMail is initialized
            if (!isset(SendMail::$sendmail)) {
                new SendMail();
            }
        
            SendMail::$sendmail->sendMail($email, $subject, $body);

        }

    }

}
?>

