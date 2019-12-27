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
            <p style="text-align: center;">
                Внимание! Скидки и акции не суммируются.
            </p>
            <div class="stock row">
                <?php foreach ($model as $item) { ?>
                <a href="<?= Url::toRoute(['view', 'id' => $item->id]) ?>"><img src="<?=(new MyImagePublisher($item))->MyThumbnail(300,142)?>" alt="<?= $item->title ?>"></a>
                <?php } ?>
            </div>
            

        </div>

    </div>