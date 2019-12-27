<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

                <?php $form = ActiveForm::begin([
                    'id' => 'callback-form',
    'errorCssClass' => 'error',
                   // 'errorCssClass' => 'hint',
                    'action' => Url::toRoute(['site/callback']),
                    'options' => ['data-pjax' => true],
                ]); ?>

                    <h2>Обратный звонок</h2>

                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-cell">Представьтесь</div>
                            <div class="form-cell">
                                <div class="input-data">
                                    <?= $form->field($callback_form, 'name')->textInput(['autofocus' => true])->label(false) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-cell">Телефон</div>
                            <div class="form-cell">
                                <div class="input-data">
                                    <?= $form->field($callback_form, 'phone')->textInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="_txt-center">
                        <?= Html::submitButton('Отправить', ['class' => 'btn green', 'name' => 'login-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>