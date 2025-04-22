<?php

namespace app\models;

use app\core\Model;
use app\core\Application; // Import Application class
use app\models\User; // Import User class

class LoginForm extends Model
{
    public string $email = '';
    public string $mobile_number = '';
    public ?string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'mobile_number' => [self::RULE_REQUIRED, self::RULE_MOBILE],
            // 'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
            
        ];
    }

    public function labels(): array
    {
        return [
            'email' => 'Your Email',
            'mobile_number' => 'Mobile Number',
            'password' => 'Password',
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email, 'mobile_number' => $this->mobile_number]);
        if (!$user) {
            $this->addError('email', 'Email and Mobile Number do not match or user does not exist');
            return false;
        }

        if (!empty($this->password)) {
            if (!password_verify($this->password, $user->password)) {
                $this->addError('password', 'Password is incorrect');
                return false;
            }
        }
        
        

        return Application::$app->login($user);
        
        // Application::$app->response->redirect('/otp');
        // return true;  
    }
}