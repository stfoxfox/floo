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

$this->title = "Заказ номер: ".$order->id;

?>


<div class="row">

    <div class="col-md-6">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Информация отзывк</h5>
            </div>
            <div class="ibox-content">
                            <span>
                                Сумма заказа
                            </span>
                <h2 class="font-bold">
                   <?=$order->order_summ?> руб.
                </h2>
                <span>
                                Сумма к оплате
                            </span>
                <h3 class="font-bold">
                    <?=$order->payment_summ?> руб.
                </h3>

                <span>
                                Оплачено бонусами
                            </span>
                <h3 class="font-bold">
                    <?=$order->points_number?> руб.
                </h3>
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
                <div class="m-t-sm hidden">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Checkout</a>
                        <a href="#" class="btn btn-white btn-sm"> Cancel</a>
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

                Сдача с: <?=$order->change_sum?>


            </div>
        </div>


    </div>
</div>
