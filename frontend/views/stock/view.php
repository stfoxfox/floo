<?php

use yii\helpers\Url;
use frontend\assets\StockAsset;
use common\components\MyExtensions\MyImagePublisher;
$stock_asset = StockAsset::register($this);
$this->title = 'Акции';

?>
    <div class="content">


        <div class="wrapper">

            <h2 class="big">Акции</h2>

            <div class="stock row">

                <img src="<?=(new MyImagePublisher($model))->MyThumbnail(300,142)?>" alt="<?= $model->title ?>" class="m-b30">

                <p><?= $model->title ?></p>
                <p><?= $model->description ?></p>

            </div>

        </div>

    </div>