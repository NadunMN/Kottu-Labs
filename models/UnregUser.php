<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\ReviewModel;
use app\core\Application;

class UnregUser extends DbModel
{

    public int $temp_id;
    public string $reservation_name= '';
    public string $email = '';
    public string $reservation_date = '';
    public string $reservation_time = '';
    public string $number_of_guests ='';
    public string $branch_id ='';
    public int $confirmation_status = 0;
    public string $type = '';
    public ?int $table_number = null; // Assuming this is an integer, adjust as necessary
    

    public static function tableName(): string
    {
        return 'unreguser';
    }

    public static function primaryKey(): string
    {
        return 'temp_id';
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
        return ['reservation_name', 'email', 'reservation_date', 'reservation_time', 'number_of_guests', 'branch_id', 'confirmation_status', 'type', 'table_number'];
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


    public static function findAlladmin($where)
{
    $tableName = static::tableName();
    $attributes = array_keys($where);

    $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("
        SELECT reviews.*, CONCAT(users.firstname, ' ', users.lastname) as userName, branches.branch_name as branchName
        FROM $tableName 
        JOIN users ON reviews.user_id = users.id
        JOIN branches ON users.branch_id = branches.branch_id;
        
    ");
    foreach ($where as $key => $value) {
        $statement->bindValue(":$key", $value);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
}




    public function toArray(): array
    {
        return [
            'temp_id' => $this->temp_id,
            'user_name' => $this->reservation_name,
            'email' => $this->email,
            'reservation_date' => $this->reservation_date,
            'reservation_time' => $this->reservation_time,
            'number_of_guests' => $this->number_of_guests,
            'branch_id' => $this->branch_id,
            'confirmation_status' => $this->confirmation_status,
            'type' => $this->type,   
            'table_number' => $this->table_number, 
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
            error_log("Binding $attribute with value: " . $this->{$attribute}); // Log the binding
        }
        if($statement->execute()) {
            $lastInsertId = Application::$app->db->pdo->lastInsertId();
            $primaryKey = static::primaryKey(); // Get the primary key attribute
            $this->{$primaryKey} = $lastInsertId; // Assign the last insert ID to the primary key attribute
            
            return $lastInsertId;
            // return true;
        } else {
            // Handle error
            error_log('Failed to save UnregUser: ' . implode(", ", $statement->errorInfo()));
            return false;
        }
      
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

        error_log("Updating UnregUser with attributes: " . implode(", ", $params)); // Log the attributes being updated
        error_log("Primary key value: " . $this->{static::primaryKey()}); // Log the primary key value
        error_log("Table name: " . $this->confirmation_status); // Log the table name   
        // exit;
        // Assuming primaryKey() returns a string key name
        $primaryKey = static::primaryKey();
        $sql = "UPDATE $tableName SET confirmation_status=:confirmation_status" . " WHERE $primaryKey = :$primaryKey";
        
        // Ensure prepare method is available and connects to PDO
        $statement = self::prepare($sql);  // Ensure `prepare` is implemented correctly
        
        // Bind attribute values
        
        $statement->bindValue(":confirmation_status", $this->confirmation_status);
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

    public static function getSeatAvailability($where)
    {
        $tableName = static::tableName();
    
        // Validate required parameters
        if (!isset($where['branch_id']) || !isset($where['reservation_time'])) {
            error_log('Missing branch_id or reservation_time in query');
            return false;
        }
    
        // Fetch total_seats from branches and sum reservations for the given time
        $sql = "
            SELECT 
                branches.seats,
                COALESCE(SUM($tableName.number_of_guests), 0) AS reserved_seats
            FROM branches
            LEFT JOIN $tableName 
                ON branches.branch_id = $tableName.branch_id
                AND $tableName.reservation_time = :reservation_time
            WHERE branches.branch_id = :branch_id
            GROUP BY branches.branch_id
        ";
    
        $statement = self::prepare($sql);
        $statement->bindValue(":branch_id", $where['branch_id']);
        $statement->bindValue(":reservation_time", $where['reservation_time']);
    
        try {
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Database error in getSeatAvailability: ' . $e->getMessage()); // Log internally
            return false; // Do not expose errors to the client
        }
    }


    public static function findAllreservationUnReg($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        // Start with the base WHERE clause
        $sql = "SELECT $tableName.* FROM $tableName WHERE confirmation_status = 1 AND type = 'dinein'";
        // Append additional conditions if any
        if (!empty($attributes)) {
            $sql .= " AND " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        }
        $statement = self::prepare($sql);
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }


    public function addTable()
    {
        $tableName = static::tableName();
        
        // Ensure table_number and reservation_no are properties
        if (!isset($this->table_number) || !isset($this->temp_id)) {
            throw new \Exception("Table number or reservation number is not set.");
        }

    

        $sql = "UPDATE $tableName SET table_number = :table_number, confirmation_status = :confirmation_status WHERE temp_id = :temp_id";
    
        $statement = self::prepare($sql);
        $statement->bindValue(':table_number', $this->table_number);
        $statement->bindValue(':temp_id', $this->temp_id);
        $statement->bindValue(':confirmation_status', $this->confirmation_status);
    
        return $statement->execute();
    }
    

    
    

}