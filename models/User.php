<?php

namespace app\models;

use app\core\Model\UserModel;

class User extends UserModel
{


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $id = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE;
    public string $position = 'customer'; // Default position
    public ?string $date_of_birth = '';
    public string $mobile_number = '';
    public string $gender = '';
    public string $address = '';
    public string $nationality = '';
    public string $created_at = '';
    public ?int $branch_id = 1;

    public static User $use;
    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    // public function save()
    // {
    //     $this->status = self::STATUS_INACTIVE;
    //     $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    //     return parent::save();
    // }

    public function rules(): array
    {
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            // 'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 16]],
            // 'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
            'mobile_number' => [self::RULE_MOBILE, [self::RULE_UNIQUE, 'class' => self::class]],
        ];
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
        return ['id','firstname', 'lastname', 'email', 'branch_id', 'status', 'position',
         'mobile_number', 'gender', 'address', 'nationality',  'date_of_birth'];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'email' => 'Your Email',
            'mobile_number' => 'Mobile Number',
            // 'gender' => 'Gender',
            // 'address' => 'Address',
            // 'nationality' => 'Nationality',
        ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'status' => $this->status,
            'position' => $this->position,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'nationality' => $this->nationality,
            'created_at' => $this->created_at,
            'branch_id' => $this->branch_id,
        ];
    }

    public function save()
    {
        $tableName = static::tableName();
        $attributes = $this->attributes();
        

        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',', $params).")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
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

    public static function findOne($where)
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

    private function isEmailUnique()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $sql = "SELECT COUNT(*) FROM $tableName WHERE email = :email AND $primaryKey != :$primaryKey";
        $statement = self::prepare($sql);
        $statement->bindValue(':email', $this->email);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        $statement->execute();
        return $statement->fetchColumn() == 0;
    }




    private function isPhoneNumberUnique()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();
        $sql = "SELECT COUNT(*) FROM $tableName WHERE mobile_number = :mobile_number AND $primaryKey != :$primaryKey";
        $statement = self::prepare($sql);
        $statement->bindValue(':mobile_number', $this->mobile_number);
        $statement->bindValue(":$primaryKey", $this->{$primaryKey});
        $statement->execute();
        return $statement->fetchColumn() == 0;
    }


    public function update()
    {

           // Check if email is unique
    if (!$this->isEmailUnique()) {
        throw new \Exception("Update failed: Email already in use") ;
        return false;
    }

    // Check if phone number is unique
    if (!$this->isPhoneNumberUnique()) {
        echo "Update failed: Phone number already in use";
        return false;
    }


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