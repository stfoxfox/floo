<?php

use common\models\Promo;
use common\models\RestaurantZone;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\assets\CartAsset;
use common\components\MyExtensions\MyImagePublisher;
$cart_asset = CartAsset::register($this);

$this->title = 'Корзина';

$session = Yii::$app->session;

$restaurant_zone_id = $session->get('restaurant_id',false);

$min_order=false;
$stop_list=array();

$promo_id=false;

/**
 * @var Promo $promo
 */
$promo=false;

$has_stop = false;


$selected_gift = $session->get('selected_gift_id',false);

$promo = Promo::find()->where("min_order<{$cart->order_summ}")->one();

if ($promo){

    $promo_id = $promo->id;
    if (!$selected_gift) {
        // $selected_gift = $promo->catalogItems[0]->id;
    }
}else{

    $session->set('selected_gift_id',false);


}


if ($restaurant_zone_id){

    /**
     * @var RestaurantZone $zone
     * @var \common\models\Restaurant $restaurant
     */
    $zone = RestaurantZone::findOne($restaurant_zone_id);
    $restaurant= $zone->restaurant;
    $min_order=$zone->min_order;
    $stop_list = $restaurant->getStopListElements()->select('catalog_item_id')->asArray()->all();


    $stop_list = \yii\helpers\ArrayHelper::getColumn($stop_list,'catalog_item_id');





}
else{

    $min_order =650;
}

$session->set('promo_id',$promo_id);
$session->set('selected_gift_id',$selected_gift);


?>
	<div class="content">


        <div class="wrapper basket product">


            <h2 class="big">Корзина</h2>

            <div class="basket-list">

                <?php

                /**
                 * @var \common\models\Cart $cartItemt
                 */
                foreach ($cart->cartItems as $key => $cartItem) { ?>
                <div class="basket-row basket-catalogItem-id " data-id="<?= $cartItem->id; ?>">
                    <div class="cell">
                        <a href="<?= Url::toRoute(['/menu/product', 'id' => $cartItem->catalogItem->id]) ?>">
                            <span class="wr-img">
                                <img src="<?=(new MyImagePublisher($cartItem->catalogItem))->MyThumbnail(210,210)?>" alt="<?= $cartItem->catalogItem->title ?>">
                            </span>
                            <span class="name"><?= $cartItem->itemTitle ?></span>
                            <?php if(!$cartItem->catalogItem->in_basket_page){?>
                            <span class="param">
                                <?php switch ($cartItem->catalog_item_pizza_options) {
                                    case 0:
                                        echo "Доставка";
                                        break;
                                    case 1:
                                        echo "С/вывоз";
                                        break;
                                    case 2:
                                        echo "Доставка";
                                        break;
                                    
                                    default:
                                        echo "С/вывоз";
                                        break;
                                }  ?>

                                <?php if(count($cartItem->cartItemModificators)>0){ ?>


                                    <br>+
                                    <?php foreach ($cartItem->cartItemModificators as $modificator) { ?>
                                        <?= $modificator->modificator->title ?>
                                    <?php } ?>


                                <?php } ?>
                            </span>
                            <?php }?>
                        </a>



                        <?php


                        if(\yii\helpers\ArrayHelper::isIn($cartItem->catalogItem->id,$stop_list)) {

                            $has_stop =true;

                            ?>
                        <div class="error-text">
                            К сожалению, данное блюдо недоступно для заказа сегодня. Выберите, пожалуйста, альтернативное блюдо в
                           меню.
                        </div>
                        <?php } ?>
                    </div>
                    <div class="cell">
                        <div class="btn-group number-group">
                            <a href="<?=Url::toRoute(['decrease-count','id'=>$cartItem->id])?>" type="button" class="btn border btn-number" data-type="minus"></a>
                            <input data-input-number="" type="text" name="" class="btn border input-number" value="<?= $cartItem->count ?>" min="1" readonly="">
                            <a href="<?=Url::toRoute(['increase-count','id'=>$cartItem->id])?>"  type="button" class="btn border btn-number" data-type="plus"></a>
                        </div>
                        <a  href="<?=Url::toRoute(['item-dell','id'=>$cartItem->id])?>" class="close-icon "></a>
                        <div class="rub"><?= $cartItem->sum ?> руб.</div>
                    </div>
                </div>
                <?php } ?>

            </div>

            <?php if ($promo) { ?>


                <div class="present">
                    <div class="present-info">
                        <div class="present-title">Ваш заказ участвует в акции:</div>
                        <div class="present-text"><?= $promo->title?></div>
                        <div class="present-check">выберите подарок:</div>
                    </div>

                    <div class="present-list product-slider">

                        <?php foreach ($promo->catalogItems as $item) : ?>
                            <div class="item">
                                <a target="_blank" href="#" class="item-link <?= $selected_gift==$item->id ? 'select' : ''?>" data-check-present="<?=$item->id?>">
                                    <img src="<?=(new MyImagePublisher($item))->MyThumbnail(210,210)?>" alt="<?= $item->title ?>">
                                    <div class="name"><?= $item->title ?></div>
                                    <button class="btn pink small"><span>выбрать</span><span class="_h">выбрано</span></button>
                                </a>
                            </div>
                        <?php endforeach ?>
                        <div class="item" data-example style="display:none;">
                            <a target="_blank" class="item-link" data-check-present>
                                <img alt="">
                                <div class="name"></div>
                                <button class="btn pink small"><span>выбрать</span><span class="_h">выбрано</span></button>
                            </a>
                        </div>
                    </div>
                </div>



            <?php } ?>
            <div class="row">
                <div class="basket-sum">

                    <div class="total-info">
                        <span class="total"><?= $cart->order_summ?> руб.</span>
                    </div>
                </div>
            </div>

            <div class="apply">
                <div class="text">
                   
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'cart-order-form',
                    'action' => Url::toRoute(['order/index']),
                ]); ?>
                    <?= Html::hiddenInput('cart_id', $cart->id); ?>
                    <?= Html::hiddenInput('is_pickup', $isPickup) ?>
                    <button id="submit-cart" <?=( ($min_order - $cart->order_summ) > 0 || $has_stop )?'disabled="disabled"':""?> class="btn pink big order-button">оформить заказ</button>
                <?php ActiveForm::end(); ?>
            </div>

            <?= \frontend\widgets\giftCard\GiftCardWidget::widget(); ?>

        </div>

    </div>