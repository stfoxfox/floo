<?php
/**
 * @var \common\models\CatalogItem $product
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;
$this->title = $product->category->title . ' - ' . $product->title;

?>
    <div class="content basket-catalogItem-id" data-id="<?= $product->id; ?>">


        <div class="wrapper product <?= ($product->category->alias != null) ? $product->category->alias : 'product'; ?>-style card">

            <div class="breadcrumb">
                <a href="/">сады сальвадора</a>
                <a href="<?= !empty($product->category->alias) ? Url::toRoute(['dish', 'alias' => $product->category->alias]) : Url::toRoute(['dish', 'id' => $product->category->id]) ?>"><?= $product->category->title ?></a>
            </div>

            <div class="row">
                <div class="col col_2 product-img">

                    <img src="<?=(new MyImagePublisher($product))->MyThumbnail(536,536)?>" alt="<?= $product->title ?>">

                </div>
                <div class="col col_2 _p5">
                    <span class="title icon-<?= $product->css_class; ?>"><?= $product->title; ?></span>
                    <div class="text-intro">
                        <?= $product->description; ?>
                    </div>
                    <div class="set row">
                        <?php if(!$product->in_basket_page){ ?>
                        <div class="set-col">

                            <!-- <div class="gr"><?=$product->packing_weights?></div> -->
                            
                            <div class="btn-group number-group">
                                <button data-btn-number type="button" class="btn border btn-number" data-type="minus"></button>
                                <input data-input-number type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly>
                                <button data-btn-number type="button" class="btn border btn-number" data-type="plus"></button>
                            </div>
                           

                        </div>
                        <?php }else{ ?>
                            <div class = "free">Бесплатно</div>
                            <input data-input-number type="hidden" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly>
                        <?php }?>
                        <?php 
                        $cookies = \Yii::$app->request->cookies;
                       
                        $id =  isset($cookies['cart']) ? $cookies['cart']->value : 0;
                        $cart = \common\models\Cart::find()->where(['id' => $id])->one();
                        if(($cart !== null && $product->in_basket_page) || !$product->in_basket_page){
                        ?>

                        <div class="set-col">

                            <div class="rub" <?php if($product->in_basket_page) echo "style='display:none'"?> ><?= empty($product->price_st_st)? $product->price : $product->price_st_st ?> руб.</div>

                            <button class="btn pink small basket-catalogItem-addtocart">
                                в корзину
                            </button>

                        </div>
                        <?php } ?>
                        <?php if($product->in_basket_page){?>
                            <select style="display:none;" name="" id="">
                                <input style="display:none;" value="st_st"  data-price="<?= $product->price_st_st ?>" class="checkbox size-radio" type="radio" name="radio" id="radio-1" checked> 
                            </select>
                            
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php if(!$product->in_basket_page){ ?>
                <?= \frontend\widgets\moreProduct\MoreProductWidget::widget(); ?>
            <?php } ?>
        </div>

    </div>