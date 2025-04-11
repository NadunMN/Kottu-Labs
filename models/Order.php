
<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\OrderModel;
use app\core\Application;
use app\core\Model\ReservationModel;

class Order extends OrderModel
{
    public string $order_id = '';
    public string $order_date = '';
    public string $order_time = '';
    public int $order_status = 0;
    public string $branch_id = '';
    public string $user_id = '';
    public string $reservation_no = '';
    public int $order_price;

    public static function tableName(): string
    {
        return 'orders';
    }

    public static function primaryKey(): string
    {
        return 'order_id';
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
        return ['order_id', 'order_date', 'order_time', 'order_status', 'branch_id', 'reservation_no', 'user_id', 'order_price'];
    }

    public function rules(): array
    {
        return [
            'order_id' => [self::RULE_REQUIRED],
            'order_date' => [self::RULE_REQUIRED],
            'order_type' => [self::RULE_REQUIRED],
            'order_status' => [self::RULE_REQUIRED],
            'branch_id' => [self::RULE_REQUIRED],
            'user_id' => [self::RULE_REQUIRED],
            'reservation_no' => [self::RULE_REQUIRED],
            'order_price' => [self::RULE_REQUIRED],
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
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
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
            
            // Fetch as an associative array to avoid dynamic property issues
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public static function findAllProfit($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        // Generate the WHERE clause dynamically if conditions exist
        $sql = $attributes ? " WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes)) : "";

        $statement = self::prepare("
            SELECT 
            branches.branch_name AS branchName,
            SUM($tableName.order_price) AS total_price
            FROM $tableName
            JOIN branches ON $tableName.branch_id = branches.branch_id
            GROUP BY branches.branch_name
            $sql
        ");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        try {
            $statement->execute();
            
            // Fetch as an associative array to avoid dynamic property issues
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public static function orderCount($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        // Generate the WHERE clause dynamically if conditions exist
        $sql = $attributes ? " WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes)) : "";

        $statement = self::prepare("
            SELECT 
                branches.branch_name AS branchName,
                MONTH($tableName.order_date) AS orderMonth,
                COUNT($tableName.order_price) AS order_count,
                Year($tableName.order_date) AS orderYear
            FROM $tableName
            JOIN branches ON $tableName.branch_id = branches.branch_id
            WHERE YEAR($tableName.order_date) = YEAR(CURDATE())
            GROUP BY branches.branch_name, MONTH($tableName.order_date)
            ORDER BY branches.branch_name, orderMonth;


            $sql
        ");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        try {
            $statement->execute();
            
            // Fetch as an associative array to avoid dynamic property issues
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }







    public function toArray(): array
    {
        return [
            'order_id' => $this->order_id,
            'order_date' => $this->order_date,
            'order_type' => $this->order_time,
            'order_status' => $this->order_status,
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,     
            'reservation_no' => $this->reservation_no,
            'order_price' => $this->order_price,
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

        try {
            if ($statement->execute()) {
                // Retrieve and set the last inserted ID
                $lastInsertId = Application::$app->db->pdo->lastInsertId();
                $primaryKey = static::primaryKey(); // Get the primary key attribute
                $this->{$primaryKey} = $lastInsertId; // Assign the last insert ID to the primary key attribute
                
                return $lastInsertId;
            }
        } catch (\PDOException $e) {
            // Log or handle the error appropriately
            echo "Error saving record: " . $e->getMessage();
        }

        return false;
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