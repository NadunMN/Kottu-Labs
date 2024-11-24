<?php

namespace app\core\Model;
use app\core\db\DbModel;

abstract class ReviewModel extends DbModel
{

    
    abstract public function toArrayReview(): array;
    abstract public function save();
    abstract public function delete();
    abstract public function update();


}