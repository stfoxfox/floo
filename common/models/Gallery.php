<?php

namespace common\models;

use Yii;
use common\models\BaseModels\GalleryBase;

class Gallery extends GalleryBase
{

    public function uploadTo($attribute)
    {
        if ($this->$attribute) {
            return Yii::getAlias('@common') . "/uploads/gallery/{$this->$attribute}";
        } else {
            return null;
        }
    }
}