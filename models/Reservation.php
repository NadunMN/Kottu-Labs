<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\ReservationModel;

class Reservation extends ReservationModel
{

    public string $reservation_no = '';
    public string $reservation_date = '';
    public string $reservation_time = '';
    public string $number_of_guests = '';
    public int $confirmation_status = 0;
    public string $branch_id = '';
    public string $user_id = '';
    public string $otp;
    
    

    public static function tableName(): string
    {
        return 'reservations';
    }

    public static function primaryKey(): string
    {
        return 'reservation_no';
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
        return ['reservation_no','reservation_date', 'reservation_time', 'number_of_guests', 
        'confirmation_status', 'branch_id', 'user_id'];
    }

    public function rules(): array
    {
        return [
            'reservation_no' => [self::RULE_REQUIRED],
            'reservation_date' => [self::RULE_REQUIRED],
            'reservation_time' => [self::RULE_REQUIRED],
            'number_of_guests' => [self::RULE_REQUIRED],
            'confirmation_status' => [self::RULE_REQUIRED],
            'branch_id' => [self::RULE_REQUIRED],
            'user_id' => [self::RULE_REQUIRED],
            
        ];
    }

    public static function findOtp($reservationNo){
        $tableName = static::tableName();
        $sql = "SELECT otp FROM $tableName WHERE reservation_no = :reservation_no LIMIT 1";
    
        $statement = self::prepare($sql);
        $statement->bindValue(":reservation_no", $reservationNo);
    
        try {
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result ? $result['otp'] : null; // Return OTP if found, otherwise null
        } catch (\PDOException $e) {
            error_log("Error fetching OTP: " . $e->getMessage());
            return null;
        }
    }

    public static function findAll($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
    
        // Generate the WHERE clause dynamically
        $sql = implode(" AND ", array_map(fn($attr) => "`$attr` = :$attr", $attributes));
    
        $statement = self::prepare("
            SELECT 
                $tableName.*, 
                CONCAT(users.firstname, ' ', users.lastname) AS userName, 
                branches.branch_name AS branchName
            FROM `$tableName`
            JOIN users ON $tableName.user_id = users.id
            JOIN branches ON $tableName.branch_id = branches.branch_id
            
        ");
    
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
    
        // Error handling for the SQL execution
        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
        } catch (\PDOException $e) {
            // Log or handle the error appropriately
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function toArray(): array
    {
        return [
            'reservation_no' => $this->reservation_no,
            'reservation_date' => $this->reservation_date,
            'reservation_time' => $this->reservation_time,
            'number_of_guests' => $this->number_of_guests,
            'confirmation_status' => $this->confirmation_status,
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,     
            'otp' => $this->otp
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