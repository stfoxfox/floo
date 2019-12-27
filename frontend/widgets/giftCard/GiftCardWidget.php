<?php

namespace frontend\widgets\giftCard;

use yii\base\Widget;
use yii\helpers\Html;
use common\models\CatalogItem;

class GiftCardWidget extends Widget
{
    public $additionoal;

    public function init()
    {
        parent::init();
        if ($this->additionoal === null) {
            $this->additionoal = CatalogItem::find()->where(['in_basket_page' => true])->limit(10)->all();
        }
    }

    public function run()
    {
        return $this->render('index', ['additionoal' => $this->additionoal]);
    }
}