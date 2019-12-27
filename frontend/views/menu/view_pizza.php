<?php

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
$this->title = $product->category->title . ' - ' . $product->title;

?>
    <div class="content basket-catalogItem-id" data-id="<?= $product->id; ?>">


        <div class="wrapper  product pizza card">

            <div class="breadcrumb">
                <a href="/">сады сальвадора</a>
                <a href="<?= !empty($product->category->alias) ? Url::toRoute(['dish', 'alias' => $product->category->alias]) : Url::toRoute(['dish', 'id' => $product->category->id]) ?>"><?= $product->category->title ?></a>
            </div>

            <div class="row">
                <div class="col col_2 product-img">

                    <img src="<?=(new MyImagePublisher($product))->MyThumbnail(536,536)?>" alt="<?= $product->title ?>" alt="<?= $product->title ?>">

                </div>
                <div class="col col_2 _p5">
                    <span class="title icon-<?= $product->css_class; ?>"><?= $product->title; ?></span>
                    <div class="text-intro">
                        <?= $product->description; ?>
                    </div>
                    <div class="set pizza">
                        <?php if(!$product->in_basket_page){?>
                        <div class="title-set">Выбрать к букету камень-комплимент:</div>
                        <div class="set-scroll-product" data-set-scroll>
                            <?php foreach ($product->modificators as $modificator) { ?>
                            <div class="set-list">
                                <div class="btn-group number-group">
                                    <button data-btn-number type="button" class="btn border btn-number" data-type="minus"></button>
                                    <input data-id="<?=$modificator->id?>" data-input-number type="text" name="" class="btn border input-number basket-modificator-count" value="0" min="0" readonly>
                                    <button data-btn-number type="button" class="btn border btn-number" data-type="plus"></button>
                                </div>
                                <div class="set-title" data-title="">
                                    <a href="<?= Url::toRoute(['/menu/modificator', 'id' => $modificator->id]) ?>" class="modificator-link">
                                        <?= $modificator->title." (бесплатно)" ?>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="check-size">
                            <div class="title-set">выбрать вариант отправки букета<p> (доставляем в пределах мкад)</div>
                            <div class="radio-button-box">
                            <label class="checkbox-label radio">
                                <input value="st_st"  data-price="<?= $product->price_st_st ?>" class="checkbox size-radio" type="radio" name="radio" id="radio-1" >
                                <span class="checkbox-label-text">С/вывоз</span>
                            </label>
                            <label class="checkbox-label radio">
                                <input value="big_st"  data-price="<?= $product->price_big_st ?>" class="checkbox size-radio" type="radio" name="radio" id="radio-2" checked>
                                <span class="checkbox-label-text">Доставка</span>
                            </label>
                            </div>

                        </div>
                        <?php } ?>
                        <div id="item_price" class="rub"><?= $product->price_big_st?> руб.</div>

                        <!-- <div id="item_price" class="rub"><?php // empty($product->price_st_st)?'':$product->price_st_st.' руб.'; ?></div> -->
                        <?php if(!$product->in_basket_page){ ?>
                        <div class="set-col">
                            
                            <div class="btn-group number-group">
                                <button data-btn-number="" type="button" class="btn border btn-number" data-type="minus"></button>
                                <input data-input-number="" type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly="">
                                <button data-btn-number="" type="button" class="btn border btn-number" data-type="plus"></button>
                            </div>
                            
                                
                        </div>
                        <?php }else{?>
                            <input style="display: none" data-input-number="" type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly="">
                        <?php }?>
                        <?php 
                        $cookies = \Yii::$app->request->cookies;
                       
                        $id =  isset($cookies['cart']) ? $cookies['cart']->value : 0;
                        $cart = \common\models\Cart::find()->where(['id' => $id])->one();
                        if(($cart !== null && $product->in_basket_page) || !$product->in_basket_page){
                        ?>
                        <div class="set-col">
                            <button class="btn pink small basket-catalogItem-addtocart">
                                в корзину
                            </button>
                        </div>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>

            <?php if(!$product->in_basket_page){ ?>
                <?= \frontend\widgets\moreProduct\MoreProductWidget::widget(); ?>
            <?php } ?>

        </div>

    </div>