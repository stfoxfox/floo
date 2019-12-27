<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;


use common\models\CatalogCategory;
use common\models\Region;
use yii\base\Model;

class AddRegionForm extends Model
{


    public $title;


    public function rules()
    {
        return [

            ['title', 'required'],
            ['title', 'filter', 'filter' => 'trim'],

        ];
    }



    public function createRegion(){

        if ($this->validate()){

            $newRegion = new Region();

            $newRegion->title=$this->title;

            if ($newRegion->save()){

                return $newRegion;
            }


        }


        return false;
    }

}