<?php

namespace app\core\Model;
use app\core\db\DbModel;

abstract class ReservationModel extends DbModel
{

    
    abstract public function toArray(): array;
    abstract public function save();
    abstract public function delete();
    abstract public function update();


}