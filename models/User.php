<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public string $id = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $password = '';
    public string $confirmPassword = '';
    public string $position = 'customer'; // Default position
    public ?string $date_of_birth = '';
    public string $mobile_number = '';
    public string $gender = '';
    public string $address = '';
    public string $nationality = '';
    public string $created_at = '';

    public static User $use;
    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 16]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'mobile_number' => [self::RULE_MOBILE, [self::RULE_UNIQUE, 'class' => self::class]],
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

    public function attributes(): array
    {
        return ['id','firstname', 'lastname', 'email', 'password', 'status', 'position', 'date_of_birth', 'mobile_number', 'gender', 'address', 'nationality', 'created_at'];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Your Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'mobile_number' => 'Mobile Number',
            // 'gender' => 'Gender',
            // 'address' => 'Address',
            // 'nationality' => 'Nationality',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function toArray(): array
    {
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'status' => $this->status,
            'position' => $this->position,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'nationality' => $this->nationality,
            'created_at' => $this->created_at,
        ];
    }
}