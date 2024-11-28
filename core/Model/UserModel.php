<?php

namespace app\core\Model;
use app\core\db\DbModel;

abstract class UserModel extends DbModel
{

    public string $position = 'customer'; // Default position
    public string $id = '';

    abstract public function toArray(): array;
    abstract public function getDisplayName(): string;
    abstract public function save();
    abstract public function delete();
    abstract public function update();


}