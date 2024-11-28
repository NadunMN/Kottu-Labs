<?php

namespace app\core\db;
use app\core\Model;
use app\core\Application;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    

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

    // public static function findAll($where)
    // {
    //     $tableName = static::tableName();
    //     $attributes = array_keys($where);
    //     $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    //     $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
    //     foreach ($where as $key => $item) {
    //         $statement->bindValue(":$key", $item);
    //     }
    //     $statement->execute();
    //     return $statement->fetchObject(static::class);
    // }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}