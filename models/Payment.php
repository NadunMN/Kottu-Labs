<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\PaymentModel;
use app\core\Model\OrderModel;
use app\core\Model\ReservationModel;

class Payment extends PaymentModel
{
    public string $payment_id = '';
    public string $payment_date = '';
    public string $payment_type = '';
    public int $payment_status = 0;
    public string $payment_amount = '';
    public int $branch_id = 0; // Uncommented branch_id
    public string $user_id = '';

    public static function tableName(): string
    {
        return 'payments';
    }

    public static function primaryKey(): string
    {
        return 'payment_id';
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
        return ['payment_id', 'payment_date', 'payment_type', 'payment_status', 'payment_amount', 'branch_id', 'user_id'];
    }

    public function rules(): array
    {
        return [
            'payment_id' => [self::RULE_REQUIRED],
            'payment_date' => [self::RULE_REQUIRED],
            'payment_type' => [self::RULE_REQUIRED],
            'payment_amount' => [self::RULE_REQUIRED],
            'payment_status' => [self::RULE_REQUIRED],
            'branch_id' => [self::RULE_REQUIRED],
            'user_id' => [self::RULE_REQUIRED],
        ];
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        // Generate the WHERE clause dynamically
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("
            SELECT 
                $tableName.*, 
                CONCAT(users.firstname, ' ', users.lastname) AS userName
            FROM $tableName
            JOIN users ON $tableName.user_id = users.id
            WHERE $sql
        ");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        // Error handling for the SQL execution
        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log or handle the error appropriately
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function findAll($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        // Generate the WHERE clause dynamically if conditions exist
        $sql = $attributes ? " WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes)) : "";

        $statement = self::prepare("
            SELECT 
                $tableName.*, 
                CONCAT(users.firstname, ' ', users.lastname) AS userName, 
                branches.branch_name AS branchName
            FROM $tableName
            JOIN users ON $tableName.user_id = users.id
            JOIN branches ON $tableName.branch_id = branches.branch_id
            $sql
        ");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log the error and rethrow it
            error_log("SQL Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'payment_date' => $this->payment_date,
            'payment_type' => $this->payment_type,
            'payment_amount' => $this->payment_id,
            'payment_status' => $this->payment_status,
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,     
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

    public function update()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        
        // Assuming primaryKey() returns a string key name
        $primaryKey = static::primaryKey();
        $sql = "UPDATE $tableName SET " . implode(', ', $params) . " WHERE $primaryKey = :$primaryKey";
        
        // Ensure prepare method is available and connects to PDO
        $statement = self::prepare($sql);  // Ensure prepare is implemented correctly
        
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