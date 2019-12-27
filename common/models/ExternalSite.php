<?php

namespace common\models;

use common\models\BaseModels\ExternalSiteBase;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "external_site".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 */
class ExternalSite extends ExternalSiteBase{


    public static function getItemsForSelect(){


        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }






}
