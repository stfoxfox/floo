<?php

namespace frontend\widgets\cashbox;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class CashboxWidget extends Widget
{

    public $component = 'yakassa';
    public $data = [];
    public $paymentType;
    public $action = 'https://demomoney.yandex.ru/eshop.xml';
    public $options;
    public $order;


    /**
     * @var string
     */
    public $submitText = 'Submit';

    public function run()
    {
        echo Html::beginForm($this->action, 'post', ['id'=>'kassa_form']);
        echo Html::hiddenInput('shopId', $this->getComponent()->shopId);
        echo Html::hiddenInput('scid', $this->getComponent()->scId);
        echo Html::hiddenInput('sum',$this->order->payment_summ ,['id'=>'kassa_order_sum']);
        echo Html::hiddenInput('customerNumber',null ,['id'=>'kassa_user_id']);
        echo Html::hiddenInput('paymentType','AC');


            echo Html::hiddenInput('cps_phone', null ,['id'=>'kassa_user_phone']);


            echo Html::hiddenInput('cps_email', null ,['id'=>'kassa_user_email']);


            echo Html::hiddenInput('orderNumber', $this->order->id ,['id'=>'kassa_order_id']);

            echo Html::submitButton('Перейти к оплате', ['class' => 'btn border']);
        echo Html::endForm();
    }

    /**
     * @return \kroshilin\yakassa\YaKassa;
     */
    public function getComponent()
    {
        return Yii::$app->get($this->component);
    }

}