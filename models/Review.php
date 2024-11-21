<?php

namespace app\models;

use app\core\db\DbModel;

class Review extends DbModel
{

    public string $review_id = '';
    public string $user_id = '';
    public string $rating = '';
    public string $review = '';
    public string $created_at = '';
    

    public static function tableName(): string
    {
        return 'reviews';
    }

    public static function primaryKey(): string
    {
        return 'review_id';
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
        return ['review_id','user_id', 'rating', 'review'];
    }

    public function labels(): array
    {
        return [
            // 'firstname' => 'First Name',
            // 'lastname' => 'Last Name',
            // 'email' => 'Your Email',
            // 'mobile_number' => 'Mobile Number',
            // 'gender' => 'Gender',
            // 'address' => 'Address',
            // 'nationality' => 'Nationality',
        ];
    }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            // 'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 16]],
            // 'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'mobile_number' => [self::RULE_MOBILE, [self::RULE_UNIQUE, 'class' => self::class]],
        ];
    }



    public function toArray(): array
    {
        return [
            'review_id' => $this->review_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' => $this->created_at,     
        ];
    }


    
    

}