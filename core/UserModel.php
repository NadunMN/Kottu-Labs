<?php

namespace app\core;
use app\core\db\DbModel;

abstract class UserModel extends DbModel
{

    public string $position = 'customer'; // Default position

    abstract public function toArray(): array;
    abstract public function getDisplayName(): string;
    abstract public function delete();

}