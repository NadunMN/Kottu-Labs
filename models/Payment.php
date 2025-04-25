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
    public ?int $steward_id = null;

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
        return ['payment_id', 'payment_date', 'payment_type', 'payment_status', 'payment_amount', 'order_id', 'steward_id'];
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
        $currentDate = date('Y-m-d');
        $statement = self::prepare("
            SELECT 
                $tableName.*,
                SUM($tableName.payment_amount) AS total_payment,
                r.table_number
            FROM $tableName
            JOIN orders o ON $tableName.order_id = o.order_id
            JOIN reservations r ON o.reservation_no = r.reservation_no
            JOIN branches ON o.branch_id = branches.branch_id
            WHERE branches.branch_id = :branch_id AND r.reservation_date = :current_date
            GROUP BY o.reservation_no, $tableName.payment_type, $tableName.payment_status
        ");

        $statement->bindValue(":branch_id", $branch_id);
        $statement->bindValue(":current_date", $currentDate);

        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }        
    }

    public static function findCardPayments($where)
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

    public static function findCashPayments($where)
    {
        $attributes = array_keys($where);
        $sql = $attributes ? " WHERE " . implode(" AND ", array_map(fn($attr) => "orders.$attr = :$attr", $attributes)) : "";
    
        $statement = self::prepare("
            SELECT
                payments.payment_id
            FROM payments
            JOIN orders ON payments.order_id = orders.order_id
            $sql
            AND payments.payment_status = 0 AND payments.payment_type = 'none'
            GROUP BY orders.reservation_no
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
            'steward_id' => $this->steward_id,    
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


public static function getReservationNoByPaymentId($paymentId)
{
    $tableName = static::tableName();
    $sql = "
        SELECT r.reservation_no
        FROM $tableName
        JOIN orders o ON $tableName.order_id = o.order_id
        JOIN reservations r ON o.reservation_no = r.reservation_no
        WHERE $tableName.payment_id = :payment_id
    ";

    $statement = self::prepare($sql);
    $statement->bindValue(':payment_id', $paymentId);

    try {
        $statement->execute();
        return $statement->fetchColumn();
    } catch (\PDOException $e) {
        error_log("Error fetching reservation number: " . $e->getMessage());
        return false;
    }
}

public static function getCashReservationNo($paymentId, $newStatus)
{
    // Calculate the previous status
    $previousStatus = $newStatus - 1;
    $tableName = static::tableName();

    $sql = "
        SELECT r.reservation_no
        FROM $tableName
        JOIN orders o ON $tableName.order_id = o.order_id
        JOIN reservations r ON o.reservation_no = r.reservation_no
        WHERE $tableName.payment_id = :payment_id 
            AND $tableName.payment_type = 'cash' 
            AND $tableName.payment_status = :previous_status
    ";

    $statement = self::prepare($sql);

    $statement->bindValue(':payment_id', $paymentId);
    $statement->bindValue(':previous_status', $previousStatus);

    try {
        $statement->execute();
        return $statement->fetchColumn();
    } catch (\PDOException $e) {
        error_log("Error fetching reservation number: " . $e->getMessage());
        return false;
    }
}

public static function updatePaymentsByReservation($reservationNo, $newStatus, $paymentType)
{
    $tableName = static::tableName();
    $sql = "
        UPDATE $tableName
        SET payment_status = :payment_status, payment_type = :payment_type
        WHERE order_id IN (
            SELECT order_id
            FROM orders
            WHERE reservation_no = :reservation_no
        )
        AND payment_status = 0 AND payment_type = 'none'
    ";

    $statement = self::prepare($sql);
    $statement->bindValue(':payment_status', $newStatus);
    $statement->bindValue(':payment_type', $paymentType);
    $statement->bindValue(':reservation_no', $reservationNo);

    try {
        return $statement->execute();
    } catch (\PDOException $e) {
        error_log("Error updating payments: " . $e->getMessage());
        return false;
    }
}

public static function updateCashPayments($reservationNo, $newStatus, $stewardId)
{
    $tableName = static::tableName();

    if ($newStatus === 1) {
        // First confirm: allow update and assign steward
        $sql = "
            UPDATE $tableName
            SET payment_status = :status, steward_id = :steward_id
            WHERE payment_id IN (
                SELECT p.payment_id
                FROM $tableName p
                JOIN orders o ON p.order_id = o.order_id
                WHERE o.reservation_no = :reservation_no
                AND p.payment_type = 'cash'
                AND p.payment_status = 0
            )
        ";
    } else if ($newStatus === 2) {
        // Second confirm: allow only if steward_id matches
        $sql = "
            UPDATE $tableName
            SET payment_status = :status
            WHERE payment_id IN (
                SELECT p.payment_id
                FROM $tableName p
                JOIN orders o ON p.order_id = o.order_id
                WHERE o.reservation_no = :reservation_no
                AND p.payment_type = 'cash'
                AND p.payment_status = 1
                AND p.steward_id = :steward_id
            )
        ";

    } else {
        return false;
    }

    $statement = self::prepare($sql);
    $statement->bindValue(':status', $newStatus);
    $statement->bindValue(':reservation_no', $reservationNo);
    $statement->bindValue(':steward_id', $stewardId);

    try {
        $executed = $statement->execute();
        if ($executed && $statement->rowCount() > 0) {
            return true; // At least one row was updated
        } else {
            return false; // No rows matched the conditions
        }
    } catch (\PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}


public static function findPaymentsUnReg($reservationNo)
{
    $tableName = static::tableName();

    $sql = "
        SELECT 
            p.payment_id, 
            p.payment_date, 
            p.payment_type, 
            p.payment_status, 
            o.order_id,
            om.*,
            m.meal_name,
            m.meal_price,
            r.table_number
        FROM $tableName p
        JOIN orders o ON p.order_id = o.order_id
        JOIN order_meals om ON o.order_id = om.order_id
        JOIN reservations r ON o.reservation_no = r.reservation_no
        JOIN meals m ON om.meal_id = m.meal_id
        WHERE r.reservation_no = :reservation_no AND p.payment_status !=2
        group by p.payment_id, om.meal_id
    ";

    $statement = self::prepare($sql);
    $statement->bindValue(':reservation_no', $reservationNo);

    try {
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Error fetching payment details: " . $e->getMessage());
        return false;
    }
}


public static function updatePaymentStatus($paymentId, $paymentType, $paymentStatus, $stewardId){

    $tableName = static::tableName();
    $primaryKey = static::primaryKey();

    $sql = "UPDATE $tableName SET payment_status = :payment_status, payment_type= :payment_type, steward_id= :steward_id WHERE $primaryKey = :$primaryKey";
    $statement = self::prepare($sql);
    $statement->bindValue(":$primaryKey",$paymentId);
    $statement->bindValue(":payment_type", $paymentType);
    $statement->bindValue(":payment_status", $paymentStatus);
    $statement->bindValue(":steward_id", $stewardId );
    return $statement->execute();
}








}