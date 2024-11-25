<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\MealModel;

class Meal extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $meal_id = '';
    public string $meal_name = '';
    public string $meal_price = '';
    public string $meal_description = '';
    public string $meal_photo = '';
    public int $meal_status = self::STATUS_INACTIVE;

    
    

    public static function tableName(): string
    {
        return 'meals';
    }

    public static function primaryKey(): string
    {
        return 'meal_id';
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
        return ['meal_name', 'meal_price', 'meal_photo', 'meal_description'];
    }

    public function rules(): array
    {
        return [
            'meal_name' => [self::RULE_REQUIRED],
            'meal_price' => [self::RULE_REQUIRED],
        ];
    }

//     public static function findAll($where)
// {
//     $tableName = static::tableName();
//     $attributes = array_keys($where);

//     $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
//     $statement = self::prepare("
//         SELECT reviews.*, CONCAT(users.firstname, ' ', users.lastname) as userName 
//         FROM $tableName 
//         JOIN users ON reviews.user_id = users.id 
//         WHERE $sql
//     ");
//     foreach ($where as $key => $value) {
//         $statement->bindValue(":$key", $value);
//     }
//     $statement->execute();
//     return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
// }




    public function toArray(): array
    {
        return [
               'meal_id' => $this->meal_id,
                'meal_name' => $this->meal_name,
                'meal_price' => $this->meal_price,
                'meal_description' => $this->meal_description,
                'meal_photo' => $this->meal_photo,
                'meal_status' => $this->meal_status,     
        ];
    }

    public function add()
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
    

    public function delete()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $sql = "DELETE FROM $tableName WHERE $primaryKey = :$primaryKey";
        $statement = self::prepare($sql);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        return $statement->execute();
    }

    public function update()
    {

        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        
        // Assuming primaryKey() returns a string key name
        $primaryKey = static::primaryKey();
        $sql = "UPDATE $tableName SET " . implode(', ', $params) . " WHERE $primaryKey = :$primaryKey";
        
        // Ensure prepare method is available and connects to PDO
        $statement = self::prepare($sql);  // Ensure `prepare` is implemented correctly
        
        // Bind attribute values
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
    
        // Execute statement and return result
        try {
            return $statement->execute();
        } catch (\Exception $e) {
            // Error handling here
            echo "Update failed: " . $e->getMessage();
            return false;
        }
    }
    

    
    

}