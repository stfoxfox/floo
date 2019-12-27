<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\assets\SignupAsset;

SignupAsset::register($this);

?>

                <?php 
                    $form = ActiveForm::begin([
                            'id' => 'form-signup',
                        'errorCssClass' => 'error',
                        'action' => Url::toRoute(['site/signup']),
                        'options' => ['data-pjax' => true],

                    ]); ?>

                    <h2>Регистрация</h2>

                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-cell">телефон</div>
                            <div class="form-cell _txt-right">
                                <div class="input-data phone">

                                    <?= $form->field($signup_model, 'username')->textInput(['autofocus' => true])->label(false) ?>
                                    <div class="hint">Например +7 926 000 00 00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label class="checkbox-label" tabindex="5">
                        <input class="checkbox" type="checkbox" name="ac" id="ac">
                        <span class="checkbox-label-text">Ознакомлен с <a href="#" onclick="MainManager.showModalById('modal-agreement'); $('#modal-registration').modal('hide'); return false;">условиями</a></span>
                    </label>

                    <div class="_txt-center">
                        <?= Html::submitButton('Отправить', ['class' => 'btn green', 'name' => 'signup-button', 'tabindex' => 6]) ?>


                    </div>

                <?php ActiveForm::end(); ?>
