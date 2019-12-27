<?php

use frontend\assets\CartAsset;
use frontend\widgets\cashbox\CashboxWidget;

$cart_asset = CartAsset::register($this);
$this->title = 'Оплата';

/**
 * @var \common\models\Order $order
 */
?>	
	<div class="content basket-end">


        <div class="wrapper">

            <p><?=$order->name?>, ваш заказ <?=$order->id?> успешно принят рестораном:<br> <?=$order->restaurant->address?>.</p>
            <p>Телефон: <?=$order->restaurant->phone?></p>
            <p>В ближайшее время мы свяжемся с вами</p>

            <!-- <h1>приятного аппетита</h1> -->
            <?= CashboxWidget::widget([
                    'order' => $order,
                    //'userIdentity' => Yii::$app->user->identity,
                    'data' => ['customParam' => 'value'],
                    'paymentType' => ['PC' => 'Со счета в Яндекс.Деньгах', 'AC' => 'С банковской карты']
                ]);
            ?>
            

        </div>

    </div>

    <script>
        document.forms["kassa_form"].submit();
    </script>