<?php 

use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;

?>
            <div class="title-slide">Выбрать открытку к букету:</div>

            <div class="product-slider" data-product-slider>
            <?php foreach ($additionoal as $item) { 
                // $item->file_name = $item->photo;    
            ?>
                <div class="item basket-catalogItem-id" data-id="<?= $item->id; ?>">
                    <a href="<?= Url::toRoute(['/menu/product', 'id' => $item->id]) ?>" class="item-link">
                        <img src="<?=(new MyImagePublisher($item))->MyThumbnail(536,536)?>" alt="<?= $item->title ?>">
                        <div class="name" data-height><?= $item->title ?></div>
                    </a>
                    <!-- <div class="btn-group number-group">
                        <button data-btn-number="" type="button" class="btn border btn-number" data-type="minus"></button>
                        <input data-input-number="" type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly="">
                        <button data-btn-number="" type="button" class="btn border btn-number" data-type="plus"></button>
                    </div> -->
                    <!-- <div class="rub"><?php // empty($item->price)?'':$item->price.' руб.'; ?></div> -->
                </div>
            <?php } ?>
            </div>