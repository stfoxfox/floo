<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/11/2017
 * Time: 10:21
 */

namespace common\models;


use common\models\BaseModels\VacancyBase;
use yii\helpers\ArrayHelper;

class Vacancy extends VacancyBase
{


    public function getRestaurantsList(){



        $restaurants = ArrayHelper::getColumn($this->restaurants,'address');

        return implode('<br>',$restaurants);



    }

    public static function getItemsForSelect(){


    return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }


}