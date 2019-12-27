<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 22/06/2017
 * Time: 14:22
 *
 * @var \yii\web\View $this
 * @var \common\models\Order $order
 */

use common\models\Order;
use yii\helpers\Url;

$this->title = "Заказ номер: ".$order->id;

?>


<div class="row">
    <div class="col-md-9">

        <div class="ibox">
            <div class="ibox-title">

                <h5>Корзина</h5>
            </div>
            <?php
            /**
             * @var \common\models\Cart $cart
             * @var \common\models\CartItem $item
             */
            $cart = $order->getCarts()->one();


            foreach ($cart->cartItems as $item) {


                ?>
                <div class="ibox-content">


                    <div class="table-responsive">
                        <table class="table shoping-cart-table">

                            <tbody>
                            <tr>
                                <td width="90">
                                    <div class="cart-product-imitation">
                                    </div>
                                </td>
                                <td class="desc">
                                    <h3>
                                        <a href="<?=Url::toRoute(['catalog/edit-item','id'=>$item->catalog_item_id])?>" class="text-navy">
                                            <?=$item->getItemTitle()?>
                                        </a>
                                    </h3>
                                    <p class="small">
                                        <?=$item->catalogItem->description?>
                                    </p>
                                    <?php if($item->cartItemModificators) { ?>
                                    <dl class="small m-b-none">
                                        <dt>камни</dt>
                                        <dd><?=$item->getModificatorsList()?></dd>
                                    </dl>

                                    <?php } ?>

                                </td>

                                <td>

                                    <?=$item->getPrice()?> руб.
                                </td>
                                <td width="65">
                                   x <?=$item->count?>
                                </td>
                                <td>
                                    <h4>
                                        <?=$item->getSum()?>руб.
                                    </h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            <?php
            }

            ?>

            <?php
            /**
             * @var \common\models\Cart $cart
             * @var \common\models\CartItem $item
             */



            if($item=$order->gift) {


                ?>
                <div class="ibox-content">


                    <div class="table-responsive">
                        <table class="table shoping-cart-table">

                            <tbody>
                            <tr>
                                <td width="90">
                                    <div class="cart-product-imitation">
                                    </div>
                                </td>
                                <td class="desc">
                                    <h3>
                                        <a href="#" class="text-navy">
                                            <?=$item->title?>
                                        </a>
                                    </h3>
                                    <p class="small">
                                        <?=$item->description?>
                                    </p>


                                </td>

                                <td>

                                  подарок
                                </td>
                                <td width="65">

                                </td>
                                <td>
                                    <h4>

                                    </h4>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <?php
            }

            ?>
        </div>

    </div>
    <div class="col-md-3">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Информация об оплате</h5>
            </div>
            <div class="ibox-content">
                            <span>
                                Сумма заказа
                            </span>
                <h2 class="font-bold">
                   <?=$order->order_summ?> руб.
                </h2>

                <hr>
                <span class="text-muted small">

                     <span>
                                Тип платежа
                            </span>
                    <?php switch ($order->payment_type){

                        case \common\models\Order::PAYMENT_TYPE_CASH:{ ?>
                            <span class="label label-primary">Наличные</span>
                            <?php
                        }
                            break;

                        case \common\models\Order::PAYMENT_TYPE_CARD:{
                            ?>
                            <span class="label label-danger">Карта </span>
                            <?php
                        }

                            break;

                    }
                    ?>

                    <br><br>
                              <span>
                                Статус платежа
                            </span>
                               <?php switch ($order->payment_status){

                                case \common\models\Order::PAYMENT_STATUS_WAIT:{ ?>
                                    <span class="label">Ожидает оплаты</span>
                                    <?php
                                }
                                    break;

                                case \common\models\Order::PAYMENT_STATUS_BAD:{
                                    ?>
                                    <span class="label label-warning">Оплата не прошла </span>
                                    <?php
                                }

                                    break;
                                case \common\models\Order::PAYMENT_STATUS_PAID:{
                                    ?>
                                    <span class="label label-primary">Оплачен</span>
                                    <?php
                                }

                                    break;

                            }

                            ?>
                <div class="m-t-sm">
                    <div class="btn-group">
                        <a href="<?=Url::toRoute(['change-status','id'=>$order->id,'status'=>Order::STATUS_NEW])?>" class="btn <?=$order->getStatusClass(Order::STATUS_NEW)?> btn-sm">Новый</a>
                        <a href="<?=Url::toRoute(['change-status','id'=>$order->id,'status'=>Order::STATUS_IN_PROGRESS])?>" class="btn <?=$order->getStatusClass(Order::STATUS_IN_PROGRESS)?> btn-sm">В работе</a>
                        <a href="<?=Url::toRoute(['change-status','id'=>$order->id,'status'=>Order::STATUS_IN_DELIVERY])?>" class="btn <?=$order->getStatusClass(Order::STATUS_IN_DELIVERY)?> btn-sm">На доствке </a>
                        <a href="<?=Url::toRoute(['change-status','id'=>$order->id,'status'=>Order::STATUS_DELIVERED])?>" class="btn <?=$order->getStatusClass(Order::STATUS_DELIVERED)?> btn-sm">Завершен</a>
                        <a href="<?=Url::toRoute(['change-status','id'=>$order->id,'status'=>Order::STATUS_CANCELED])?>" class="btn <?=$order->getStatusClass(Order::STATUS_CANCELED)?> btn-sm">Отменен</a>

                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Информация о клиенте</h5>
            </div>
            <div class="ibox-content text-left">

                <span >
                              <?=$order->getClientForBackend()?>
                            </span>
                <hr>

                <?=$order->getAddressForBackend()?>


            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Информация о заказе</h5>
            </div>
            <div class="ibox-content text-left">

                <span >
                    Комментарий: <?=$order->client_comment?>
                            </span>
                <hr>

                <span >
                    Открытка: <?=$order->gift_card_text?>
                            </span>
                <hr>


                Сдача с: <?=$order->change_sum?>


            </div>
        </div>


    </div>
</div>
