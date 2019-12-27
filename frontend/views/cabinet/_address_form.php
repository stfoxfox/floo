<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
$this->registerJsFile('//api-maps.yandex.ru/2.1/?lang=ru_RU&load=package.full,SuggestView&mode=debug&onload=LocationManager.initSuggestions',[ 'depends' => 'frontend\assets\OrderAsset', 'position' => \yii\web\View::POS_END]);
?>

            <?php Pjax::begin(['id' => 'address', 'enablePushState' => false]); ?>
            <?php foreach ($addresses as $key => $address) { ?>
                <div class="cabinet-row person-address-<?= $address->id ?>">

                <div class="addr-list" data-addr-list>
                    <h2 class="m-b20 small">
                        Адрес доставки
                    </h2>
                </div>

                <div class="addr-input">
                <!-- <div class="addr-input error"> -->
                    <input type="text" data-address value="<?= $address->address; ?>" disabled>
                </div>

                <div class="m-b20 input-data row">

                    <div class="form-grid _3">
                        <div class="form-row">
                            <div class="form-cell">подъезд</div>
                            <div class="form-cell">
                                <div class="input-data">
                                    <input type="text" value="<?= $address->entrance; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-cell">этаж</div>
                            <div class="form-cell">
                                <div class="input-data">
                                    <input type="text" value="<?= $address->floor; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-cell">квартира/ <br> № офиса*</div>
                            <div class="form-cell">
                                <div class="input-data">
                                    <input type="text" value="<?= $address->flat; ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="hint _error">Необходимо указать точный и корректный адрес доставки</div> -->
                </div>

                <div class="row">
                    <div class="fl-r">
                    <?= Html::a('- удалить адрес',Url::toRoute(['deladdress']), [
                        'title' => Yii::t('yii', 'Close'),
                        'onclick'=>"
                            var csrfToken = $('meta[name=\"csrf-token\"]').attr(\"content\");
                            $.ajax({
                                type     :'POST',
                                data     : {
                                    id: $address->id,
                                    \"_csrf-frontend\" : csrfToken,},
                                cache    : false,
                                url  : '".Url::toRoute(['deladdress'])."',
                                success  : function(response) {
                                    if(!response.error)
                                        $('.person-address-$address->id').remove();
                                }
                            });
                            return false;",
                        'class' => 'btn border m-r4',
                        'style' => 'text-decoration:none;',
                    ]); ?>
                        <!-- <button class="btn green" onclick="MainManager.showAlert('addr')">Изменить</button> -->
                    </div>
                </div>

            </div>
            <?php } ?>



            <div class="cabinet-row">
                <?php $form = ActiveForm::begin([
                    'id' => 'cabinet-address-form',
                    'errorCssClass' => 'error',
                    'action' => Url::toRoute(['addaddress']),
                    'options' => ['data-pjax' => true],
                ]); ?>
                <div class="addr-list" data-addr-list>
                    <h2 class="m-b20 small">
                        Добавить адрес доставки
                    </h2>
                </div>

                <!-- <div class="addr-input error"> -->
                    <?= $form->field($new_address, 'address', ['options' => ['class' => 'addr-input']])->textInput(['id' => 'orderform-address'])->label(false) ?>
                    <!-- <input type="text" data-address>
                </div> -->

                <div class="m-b20 input-data row">

                    <div class="form-grid _3">
                        <div class="form-row">
                            <div class="form-cell">подъезд</div>
                            <div class="form-cell">
                                <!-- <div class="input-data"> -->
                                    <?= $form->field($new_address, 'entrance', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                    <!-- <input type="text">
                                </div> -->
                            </div>
                            <div class="form-cell">этаж</div>
                            <div class="form-cell">
                                <!-- <div class="input-data"> -->
                                    <?= $form->field($new_address, 'floor', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                    <!-- <input type="text">
                                </div> -->
                            </div>
                            <div class="form-cell">квартира/ <br> № офиса*</div>
                            <div class="form-cell">
                                <!-- <div class="input-data"> -->
                                    <?= $form->field($new_address, 'flat', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                    <!-- <input type="text">
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!--<div class="hint _error">Необходимо указать точный и корректный адрес доставки</div>-->
                </div>

                <div class="row">
                    <div class="fl-r">
                        <button class="btn green">+ добавить адрес</button>
                        <!-- <button class="btn green" onclick="MainManager.showAlert('addr')">Сохранить</button> -->
                    </div>
                </div>
                <div class="m-b30 basket-map" id="map">
                <?php ActiveForm::end(); ?>

            </div>
            <?php Pjax::end(); ?>
