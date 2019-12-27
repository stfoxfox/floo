<?php

namespace frontend\widgets\moreProduct;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\CatalogItemModificator;

class MoreProductWidget extends Widget
{
    public $additionoal;

    public function init()
    {
        parent::init();
        if ($this->additionoal === null) {
            $this->additionoal = CatalogItemModificator::find()->limit(10)->all();
        }
    }

    public function run()
    {
        return $this->render('index', ['additionoal' => $this->additionoal]);
    }
}