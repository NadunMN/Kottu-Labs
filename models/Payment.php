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
    public string $order_id = '';

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
        return ['payment_id', 'payment_date', 'payment_type', 'payment_status', 'payment_amount', 'order_id'];
    }

    public function rules(): array
    {
        return [
            'payment_id' => [self::RULE_REQUIRED],
            'payment_date' => [self::RULE_REQUIRED],
            'payment_type' => [self::RULE_REQUIRED],
            'payment_amount' => [self::RULE_REQUIRED],
            'payment_status' => [self::RULE_REQUIRED],
            'order_id' => [self::RULE_REQUIRED],
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

    public static function findOneOriginal($where)
    {
        $tableName = static::tableName();
        $attribute = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attribute));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
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
                SUM($tableName.payment_amount) AS total_payment, 
                s.branch_id AS branch_id,
                s.reservation_no
                
            FROM $tableName
            JOIN orders s ON $tableName.order_id = s.order_id
            JOIN users ON s.user_id = users.id
            JOIN branches ON s.branch_id = branches.branch_id
            $sql
            GROUP BY s.reservation_no
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

    public static function findPaymentsByBranch($branch_id){
        $tableName = static::tableName();
        $statement = self::prepare("
            SELECT 
                $tableName.*,
                SUM($tableName.payment_amount) AS total_payment,
                r.table_number
            FROM $tableName
            JOIN orders o ON $tableName.order_id = o.order_id
            JOIN reservations r ON o.reservation_no = r.reservation_no
            JOIN branches ON o.branch_id = branches.branch_id
            WHERE branches.branch_id = :branch_id AND $tableName.payment_status = 0
            GROUP BY o.reservation_no
        ");

        $statement->bindValue(":branch_id", $branch_id);

        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }        
    }

    public static function findPayments($where)
    {
        $attributes = array_keys($where);
        $sql = $attributes ? " WHERE " . implode(" AND ", array_map(fn($attr) => "r.$attr = :$attr", $attributes)) : "";
    
        $statement = self::prepare("
            SELECT
                payments.*, 
                orders.order_id,
                order_meals.quantity,
                meals.meal_name,
                meals.meal_price

            FROM payments
            JOIN orders ON payments.order_id = orders.order_id
            LEFT JOIN order_meals ON orders.order_id = order_meals.order_id
            JOIN reservations r ON orders.reservation_no = r.reservation_no
            LEFT JOIN meals ON order_meals.meal_id = meals.meal_id
            $sql
            AND payments.payment_status = 0 AND payments.payment_type = 'none'
        ");
    
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
    
        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("SQL Error in findOrders: " . $e->getMessage() . " | Conditions: " . json_encode($where));
            throw $e;
        }
    }
    
    public function toArray(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'payment_date' => $this->payment_date,
            'payment_type' => $this->payment_type,
            'payment_amount' => $this->payment_amount,
            'payment_status' => $this->payment_status,
            'order_id' => $this->order_id,    
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
    $primaryKey = static::primaryKey();

    // Step 1: Retrieve the reservation_no for the current payment_id
    $reservationNoQuery = "
        SELECT s.reservation_no 
        FROM $tableName
        JOIN orders s ON $tableName.order_id = s.order_id
        WHERE $primaryKey = :$primaryKey
    ";
    $reservationStatement = self::prepare($reservationNoQuery);
    $reservationStatement->bindValue(":$primaryKey", $this->{$primaryKey});
    $reservationStatement->execute();
    $reservationNo = $reservationStatement->fetchColumn();

    if (!$reservationNo) {
        throw new \Exception("Reservation number not found for payment_id: " . $this->{$primaryKey});
    }

    // Step 2: Update payment_status for all payments linked to the reservation_no
    $updateQuery = "
        UPDATE $tableName
        SET payment_status = :payment_status,
            payment_type = :payment_type
        WHERE order_id IN (
            SELECT order_id 
            FROM orders 
            WHERE reservation_no = :reservation_no
        )
    ";
    $updateStatement = self::prepare($updateQuery);
    $updateStatement->bindValue(":payment_status", $this->payment_status);
    $updateStatement->bindValue(":payment_type", $this->payment_type);
    $updateStatement->bindValue(":reservation_no", $reservationNo);

    try {
        return $updateStatement->execute();
    } catch (\Exception $e) {
        // Log the error
        error_log("Update failed: " . $e->getMessage());
        return false;
    }
}




public function updateCard()
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