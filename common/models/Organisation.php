<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 15/01/2017
 * Time: 16:44
 */

namespace common\models;


use common\models\BaseModels\OrganisationBase;
use yii\helpers\ArrayHelper;

class Organisation extends OrganisationBase
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['organisation_id' => 'id']);
    }

    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }

}