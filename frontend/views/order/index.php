<?php


/**
 * @var View $this
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use frontend\assets\OrderAsset;
use frontend\widgets\cashbox\CashboxWidget;
$this->registerJsFile('//api-maps.yandex.ru/2.1/?lang=ru_RU&load=package.full,SuggestView&mode=debug&onload=LocationManager.initSuggestions',[ 'depends' => 'frontend\assets\OrderAsset', 'position' => \yii\web\View::POS_END]);

 
$this->title = "Оформить заказ";
//$order_asset = OrderAsset::register($this);

$order_button_class= "";
$order_button_yaid="";

if (isset($this->params['site_id']) &&  $this->params['site_id'] !=-1) {


    $external_site = \common\models\ExternalSite::findOne($this->params['site_id']);


    switch ($external_site->url){

        case "odin.pronto24.ru":{


            $this->registerJs("
            
            	$('#send-order').on('click',function(){


  
        yaCounter46333506.reachGoal('send-order');
    });
            ");

        }
            break;
        case "zgd.pronto24.ru":{

            $this->registerJs("
            
            	$('#send-order').on('click',function(){


  	  
        yaCounter46333419.reachGoal('send-order');
    });
            ");


        }
            break;
        case "reut.pronto24.ru":{
            $this->registerJs("
            
            	$('#send-order').on('click',function(){


  	   
        yaCounter46333473.reachGoal('send-order');
    });
            ");


        }
            break;
        case "dmit.pronto24.ru":{


            $this->registerJs("
            
            	$('#send-order').on('click',function(){
        yaCounter46333557.reachGoal('send-order');
    });
            ");




        }
            break;

    }


}


?>
    <div class="content">


        <div class="wrapper">


            <h2 class="big">Заказ</h2>

            <div class="content-form">
                <?php $form = ActiveForm::begin([
                    'id' => 'order-form',
                    'errorCssClass' => 'error',
                    // 'enableAjaxValidation' => true,
                    // 'validationUrl' => Url::toRoute('validate')
                ]); ?>
                <?= $form->errorSummary($model); ?>
                <div class="row m-b25">
                    <div class="col col_2">
                        <h2 class="m-b20 orange">Личные данные</h2>
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">имя</div>
                                <div class="form-cell">
                                    <!-- <div class="input-data"> -->
                                    <?= $form->field($model, 'name', ['options' => ['class' => 'input-data']])->textInput(['autofocus' => true])->label(false) ?>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">телефон</div>
                                <div class="form-cell _txt-right">
                                    <div class="input-data ">

                                        <?= $form->field($model, 'phone', ['template' => '{input}{error}'])->textInput(['tabindex' => 1])->label(false) ?>
                                        <!--div class="hint">Например +7 926 000 00 00</div-->
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col col_2">
                        <h2 class="m-b20 orange">Cпособ оплаты</h2>


                        <div class="checkbox-right">
                            <div class="checkbox-class-right">
                                <label class="checkbox-label radio">
                                    <input class="checkbox" type="radio" name="OrderForm[payment_type]" id="radio-1" checked value="<?= \common\models\Order::PAYMENT_TYPE_CASH; ?>">
                                    <span class="checkbox-label-text">Наличными курьеру</span>
                                </label>

                                <label class="checkbox-label radio">
                                    <input class="checkbox" type="radio" name="OrderForm[payment_type]" id="radio-2" value="<?= \common\models\Order::PAYMENT_TYPE_CARD; ?>">
                                    <span class="checkbox-label-text">Банковская карта</span>
                                </label>
                            </div>

                            <div class="right-input">
                                <span>сдача с</span>
                                <?= $form->field($model, 'change_sum', ['template' => '{input}{error}'])->textInput()->label(false) ?>
                            </div>
                        </div>
                    </div>
                </div>


                
                
                <?php if($isPickup){?>
                    <div class="addr-list">
                        <h2 class="m-b20 orange">
                            Адрес самовывоза
                        </h2>
                        
                    </div>
                    <h2 class="m-b20 orange">
                        Климентовский переулок, 2
                    </h2>
                    <?= $form->field($model, 'address', ['options' => ['class' => 'addr-input' ,'style'=>"color:#000000"]])
                            ->hiddenInput()->label(false) ?>
                <?php }else{?>
                <div class="addr-list">
                    <h2 class="m-b20 orange">
                        Адрес доставки
                    </h2>
                    
                </div>
                <div>Заполните адрес доставки</div>

                <!-- <div class="addr-input error"> -->
                    <?= $form->field($model, 'address', ['options' => ['class' => 'addr-input' ,'style'=>"color:#000000"]])
                            ->textInput()->label(false) ?>
                <?php }?>
                    <?= $form->field($model, 'lat')->hiddenInput(['value' => $isPickup ? 55.7411881 : ''])->label(false) ?>
                    <?= $form->field($model, 'lng')->hiddenInput(['value' => $isPickup ? 37.6318282 : ''])->label(false) ?>
                <!-- </div> -->
                
                <?php if(!$isPickup){?>
                <div class="m-b30 input-data row">

                        <div class="form-grid _3">
                            <div class="form-row">
                                <div class="form-cell">подъезд</div>
                                <div class="form-cell">
                                    <!-- <div class="input-data"> -->
                                        <?= $form->field($model, 'entrance', ['options' => ['class' => 'input-data']])->textInput($isPickup ? ['disabled' => true] : [])->label(false) ?>
                                    <!-- </div>
 -->                                </div>
                                <div class="form-cell">этаж</div>
                                <div class="form-cell">
                                    <!-- <div class="input-data"> -->
                                        <?= $form->field($model, 'floor', ['options' => ['class' => 'input-data']])->textInput($isPickup ? ['disabled' => true] : [])->label(false) ?>
                                    <!-- </div> -->
                                </div>
                                <div class="form-cell">квартира/ <br> № офиса*</div>
                                <div class="form-cell">
                                    <!-- <div class="input-data"> -->
                                        <?= $form->field($model, 'flat', ['options' => ['class' => 'input-data']])->textInput($isPickup ? ['disabled' => true] : [])->label(false) ?>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    <!-- <div class="hint _error">Необходимо указать точный и корректный адрес доставки</div> -->
                </div>
                <?php }?>

                <div class="m-b30 basket-map" id="map">

                </div>

                <h2 class="m-b20 orange">Комментарий к заказу</h2>

                <!-- <div class="m-b30 comment-area"> -->
                    <?= $form->field($model, 'client_comment', ['options' => ['class' => 'm-b30 comment-area']])->textArea()->label(false) ?>
                <!-- </div> -->

                <h2 class="m-b20 orange">Текст на открытке</h2>

                <!-- <div class="m-b30 comment-area"> -->
                    <?= $form->field($model, 'gift_card_text', ['options' => ['class' => 'm-b30 comment-area']])->textArea()->label(false) ?>
                <!-- </div> -->

                <h2 class="m-b20 orange">
                    Итого к оплате
                </h2>

                <div class="sum"><?= $cart->sum?>  руб.</div>

                <div class="apply">
                    <div class="text" style="display: none;">
                        К сожалению, ваш адрес не входит в зону доставки наших ресторанов, <br>
                        но вы можете сами забрать заказ в удобном для вас ресторане
                    </div>
                    <button class="btn pink big send-order" id="send-order">Отправить</button>
                </div>
                <?php
                
                ?>
                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>

<div data-alert="" class="alert info">
    <div class="wrapper" data-alert-text=""></div>
</div>