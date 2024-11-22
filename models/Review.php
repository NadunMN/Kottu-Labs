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

    public function rules(): array
    {
        return [
            'rating' => [self::RULE_REQUIRED],
            'review' => [self::RULE_REQUIRED],
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

    public function save()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);

        $sql = "INSERT INTO $tableName (" . implode(', ', $attributes) . ") 
                VALUES (" . implode(', ', $params) . ")";

        $statement = self::prepare($sql);

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        return $statement->execute();
    }

    
    

}