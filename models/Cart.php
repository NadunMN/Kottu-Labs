<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\cartModel;

class Cart extends cartModel
{
    public int $cart_id;
    public ?int $user_id=null;
    public ?int $temp_id=null;
    public ?int $meal_id = null; // Nullable to allow for optional meal_id
    public ?int $offer_id = null; // Nullable to allow for optional offer_id
    public int $quantity;
    

    public static function tableName(): string
    {
        return 'cart';
    }

    public static function primaryKey(): string
    {
        return 'cart_id';
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
        return ['user_id','temp_id', 'meal_id', 'quantity', 'offer_id'];
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
        $sql = "SELECT $tableName.*, m.*, f.*
        FROM $tableName
        LEFT JOIN meals m ON $tableName.meal_id = m.meal_id
        LEFT JOIN offers f ON $tableName.offer_id = f.offer_id";

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
            'cart_id' => $this->cart_id,
            'user_id' => $this->user_id,
            'temp_id' => $this->temp_id,
            'meal_id' => $this->meal_id,
            'offer_id' => $this->offer_id,
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
        $sql = "DELETE FROM $tableName WHERE $primaryKey = :$primaryKey";
        $statement = self::prepare($sql);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        return $statement->execute();
    }

    public function clear()
    {
        $tableName = static::tableName();
        $sql = "DELETE FROM $tableName WHERE user_id = :user_id";
        $statement = self::prepare($sql);
        $statement->bindValue(":user_id", $this->user_id);
        return $statement->execute();
    }

    public function update()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        
        // Assuming primaryKey() returns a string key name
        $primaryKey = static::primaryKey();

        error_log("Primary Key: " . $this->quantity); // Debugging line

        $sql = "UPDATE $tableName SET quantity = $this->quantity WHERE $primaryKey = :$primaryKey";
        
        // Ensure prepare method is available and connects to PDO
        $statement = self::prepare($sql);  // Ensure `prepare` is implemented correctly
        
        // // Bind attribute values
        // foreach ($attributes as $attribute) {
        //     $statement->bindValue(":$attribute", $this->{$attribute});
        // }
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