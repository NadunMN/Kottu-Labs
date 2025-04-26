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
        $this->registerMiddleware(new AuthMiddleware(['userProfile'])); //access array
    }


public function login(Request $request, Response $response)
{
    $loginForm = new LoginForm();

    if($request->isPost()){
        $loginForm->loadData($request->getBody());

        if($loginForm->validate() && $loginForm->login()){
            $user = User::findOne(['email' => $loginForm->email]);

            if($user->position == 'customer') {
                // Check the user's position
                $response->redirect('/');
                return;
            }else if($user->position == 'admin') {
                // Check the user's position
                $response->redirect('/profile');
                return;
            }else if($user->position == 'steward') {
                // Check the user's position
                $response->redirect('/profile');
                return;
            }else if($user->position == 'chef') {                // Check the user's position
                $response->redirect('/profile');
                return;
            }else{
                // Check the user's position
                $response->redirect('/profile');
                return;
            }
            
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

