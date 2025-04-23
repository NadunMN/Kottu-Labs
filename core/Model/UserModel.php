<?php

namespace app\core\Model;
use app\core\db\DbModel;

abstract class UserModel extends DbModel
{

    public string $position = 'customer'; // Default position

    public string $id = '';

    // public string $id = '';
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    // public int $status = self::STATUS_INACTIVE;
    // public string $position = 'customer'; // Default position
    public ?string $date_of_birth = '';
    public string $mobile_number = '';
    public string $gender = '';
    public ?string $address = '';
    public string $nationality = '';
    public string $created_at = '';
    public ?int $branch_id = 1;
    public ?string $photo = '';
    public string $password = '';
    public string $confirmPassword = '';

    abstract public function toArray(): array;
    abstract public function getDisplayName(): string;
    abstract public function save();
    abstract public function delete();
    abstract public function update();
    


}