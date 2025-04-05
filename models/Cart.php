<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\cartModel;

class Cart extends cartModel
{

    public int $user_id;
    public int $meal_id;
    public int $quantity;
    

    public static function tableName(): string
    {
        return 'cart';
    }

    public static function primaryKey(): string
    {
        return 'user_id';
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
        return ['user_id', 'meal_id', 'quantity'];
    }

    public function rules(): array
    {
        return [
            'rating' => [self::RULE_REQUIRED],
            'review' => [self::RULE_REQUIRED],
        ];
    }

    public static function findAll($where)
{
    $tableName = static::tableName();
    $attributes = array_keys($where);

    $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("
        SELECT reviews.*, CONCAT(users.firstname, ' ', users.lastname) as userName, branches.branch_name as branchName
        FROM $tableName 
        JOIN users ON reviews.user_id = users.id
        JOIN branches ON users.branch_id = branches.branch_id
        WHERE $sql
    ");
    foreach ($where as $key => $value) {
        $statement->bindValue(":$key", $value);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
}


public static function findAllcartMeal($where)
{
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = "SELECT $tableName.*, m.* FROM $tableName                 
                JOIN meals m ON $tableName.meal_id = m.meal_id                 
                ";
        if (!empty($attributes)) {
            $sql .= " WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        }
        $statement = self::prepare($sql);
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
}



    public function toArrayCart(): array
    {
        return [
            'user_id' => $this->user_id,
            'meal_id' => $this->meal_id,
            'quantity' => $this->quantity,
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
    

    public function delete()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $sql = "DELETE FROM $tableName WHERE $primaryKey = :$primaryKey AND meal_id = :meal_id";
        $statement = self::prepare($sql);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        $statement->bindValue(":meal_id", $this->meal_id);
        return $statement->execute();
    }

    public function clear()
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

        $sql = "UPDATE $tableName SET " . implode(', ', $params) . " WHERE $primaryKey = :$primaryKey AND meal_id = :meal_id";
        
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