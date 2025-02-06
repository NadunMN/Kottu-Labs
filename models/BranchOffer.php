<?php

namespace app\models;

use app\core\db\DbModel;
use app\core\Model\BranchOfferModel;

class BranchOffer extends BranchOfferModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $offer_id = '';
    public string $branch_id = '';
    public int $offer_status = self::STATUS_ACTIVE;

    
    

    public static function tableName(): string
    {
        return 'branch_offers';
    }

    public static function primaryKey(): string
    {
        return 'offer_id';
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
        return ['offer_id', 'branch_id', 'offer_status'];
    }

    public function rules(): array
    {
        return [
            'meal_name' => [self::RULE_REQUIRED],
            'meal_price' => [self::RULE_REQUIRED],
        ];
    }



public static function findAll($where=[])
{
    $tableName = static::tableName();
    $attributes = array_keys($where);
    $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    $statement = self::prepare("SELECT * FROM $tableName");
    foreach ($where as $key => $item) {
        $statement->bindValue(":$key", $item);
    }
    $statement->execute();
    return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
}




    public function toArray(): array
    {
        return [
               'offer_id' => $this->offer_id,
                'branch_id' => $this->branch_id ,
                'offer_status' => $this->offer_status 
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
       
        $deleteSql = "DELETE FROM $tableName WHERE $primaryKey = :meal_id AND branch_id = :branch_id";
        $deleteStatement = self::prepare($deleteSql);
        $deleteStatement->bindValue(':offer_id', $this->offer_id);
        $deleteStatement->bindValue(':branch_id', $this->branch_id);
        return $deleteStatement->execute();
    }

    public function update()
    {
        $tableName = static::tableName();
        $primaryKey = static::primaryKey();

        // Step 1: Check if the branch_id already exists for the given meal_id
        $checkSql = "SELECT 1 FROM $tableName WHERE $primaryKey = :meal_id AND branch_id = :branch_id";
        $checkStatement = self::prepare($checkSql);
        $checkStatement->bindValue(':offer_id', $this->offer_id);
        $checkStatement->bindValue(':branch_id', $this->branch_id);
        $checkStatement->execute();

        if (!$checkStatement->fetch()) {
            // Step 2: If the branch_id does not exist, insert it
            $insertSql = "INSERT INTO $tableName (meal_id, branch_id, meal_status) VALUES (:meal_id, :branch_id, :meal_status)";
            $insertStatement = self::prepare($insertSql);
            $insertStatement->bindValue(':offer_id', $this->offer_id);
            $insertStatement->bindValue(':branch_id', $this->branch_id);
            $insertStatement->bindValue(':offer_status', $this->offer_status);
            $insertStatement->execute();
        }

        return true;

    }


    public static function findAllByBranch($branchId)
    {
        $sql = "SELECT * FROM branch_meals WHERE branch_id = :branch_id";
        $statement = self::prepare($sql);
        $statement->bindValue(':branch_id', $branchId);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    

    
    

}