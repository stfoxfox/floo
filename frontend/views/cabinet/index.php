<?php

use frontend\assets\CabinetAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$cabinet_asset = CabinetAsset::register($this);
$this->title = 'Кабинет';

?>
	<div class="content-white">
        <div class="wrapper cabinet">

            <div class="row">
                <!-- <a href="<?= Url::toRoute(['/site/logout']) ?>" class="btn border fl-r">выход</a> -->
                <?= Html::a('выход', ['/site/logout'], ['class' => 'btn border fl-r', 'data-method'=>'post']) ?>
                <h2 class="big">Личный кабинет</h2>
            </div>

            <?= $this->render('_personal_form', [
                'person' => $person,
                'success' => false,
            ]); ?>

            <?= $this->render('_phone_form', [
                'phone' => $phone,
                'request_id' => false,
            ]); ?>

            

            <div class="cabinet-row scroll">
                <h2 class="small">История заказов</h2>
                <table class="order-list">
                    <thead>
                    <tr>
                        <td>номер</td>
                        <td>Дата</td>
                        <td>Заказ</td>
                        <td>сумма</td>

                        <td>повторить</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td><?= $order->id ?></td>
                        <td><?= $order->created_at ?></td>
                        <td>
                        <?php $last_line = count($order->carts);
                        foreach ($order->carts as $index => $cart) { ?>
                            <?php $last = count($cart->cartItems);
                            foreach ($cart->cartItems as $key => $cartItem) { ?>
                                <?= $cartItem->itemTitle.(($key != $last-1) ? ', ' : '') ?>
                            <?php } ?>
                            <?= ($last_line != $index-1) ? '<br>' : ''; ?>
                        <?php } ?>
                        </td>
                        <td><?= $order->order_summ ?> руб.</td>


                        <td>
                            <a class="btn orange ok" href="<?=\yii\helpers\Url::toRoute(['order/repeat','id'=>$order->id])?>"></a>
                        </td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>



            </div>



  



            <?= $this->render('_password_form', [
                'password' => $password,
                'error' => false,
            ]); ?>

        </div>
    </div>