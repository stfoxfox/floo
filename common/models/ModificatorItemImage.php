<?php

namespace common\models;


use common\models\BaseModels\ModificatorItemImageBase;
use Yii;

class ModificatorItemImage extends ModificatorItemImageBase
{
    public function uploadTo($attribute)
    {
        if ($this->$attribute) {
            return Yii::getAlias('@common') . "/uploads/modificator/{$this->modificator_item_id}/gallery/{$this->$attribute}";
        } else {
            return null;
        }
    }
}