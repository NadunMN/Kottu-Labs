<?php

namespace app\core\Model;
use app\core\db\DbModel;

abstract class cartModel extends DbModel
{

    
    abstract public function toArrayCart(): array;
    abstract public function save();
    abstract public function delete();
    abstract public function update();


}