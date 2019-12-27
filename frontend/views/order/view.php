<?php

use frontend\assets\CartAsset;
$cart_asset = CartAsset::register($this);
$this->title = 'Заказ';

/**
 * @var \common\models\Order $order
 */
?>	
	<div class="content basket-end">
        <div class="wrapper">
            <p>Ваш заказ успешно принят в работу нашим магазином цветов, расположенным по адресу:<br>Климентовский переулок, 2. </p>
            <p>Телефон: +7 495 933-28-49</p>
            <p>В ближайшее время мы свяжемся с вами</p>
        </div>
    </div>