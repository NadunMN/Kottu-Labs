<?php

namespace app\core\Model;

use app\core\db\DbModel;

abstract class BranchOfferModel extends DbModel
{

    
    abstract public function toArray(): array;
    abstract public function add();
    abstract public function delete();
    abstract public function update();


}