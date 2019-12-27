<?php

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
use frontend\assets\AppAsset;

$this->title = $product->title;
$product->file_name = $product->photo;
$asset = AppAsset::register($this);
?>
    <div class="content basket-catalogItem-id" data-id="<?= $product->id; ?>">


        <div class="wrapper  product pizza card">

            <div class="breadcrumb">
                <a href="/">сады сальвадора</a>
                <a href="#"><?= $product->title ?></a>
            </div>

            <!--Slider for main page-->
            

            <div class="row" style="margin: 0 !important;">
                <div class="col col_2 product-img">
                    <div class="main-slider-wr slider-modificator">
                        <div data-main-slider class="owl-carousel owl-theme main-slider">
                            <?php
                            foreach ($product->modificatorItemImages as $item) {
                            ?>
                                <div><a href="#"> <img src="<?=(new MyImagePublisher($item))->MyThumbnail(536,536,'file_name')?>" alt="<?= $item->text ?>"></a></div>
                            <?php } ?>
                            <?php if(!empty($product->video_link)){?>
                                <iframe width="100%" height="536" src="https://www.youtube.com/embed/<?= $product->video_link?>?rel=0&showinfo=0'.'" frameborder="0" allowfullscreen></iframe>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col col_2 _p5">
                    <span class="title icon"><?= $product->title; ?></span>
                    <div class="text-intro text-justify">
                        <?= $product->description; ?>
                    </div>
                    <div class="set pizza">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
