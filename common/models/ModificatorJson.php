<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/04/2017
 * Time: 12:51
 */

namespace common\models;


use yii\helpers\ArrayHelper;

class ModificatorJson
{


    public $item_id;
    public $count;
    public $price;

    public function loadFromJson($json){

        $this->item_id = ArrayHelper::getValue($json,'item_id',0);
        $this->count = ArrayHelper::getValue($json,'count',0);




    }

    public function getSum(){


        return $this->price*$this->count;
    }

}