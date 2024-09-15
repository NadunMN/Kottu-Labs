<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    // public string $firstname = '';
    // public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function register()
    {
        return 'Creating new user';
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 16]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function load($data)
    {
        // Load the data only if the keys exist
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    // public function validate()
    // {
    //     // Validation logic can be added here
    // }
}
