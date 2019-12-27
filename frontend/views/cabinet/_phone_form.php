<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

?> 
            <div class="cabinet-row">
            <?php Pjax::begin(['id' => 'phone', 'enablePushState' => false]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'cabinet-phone-form',
                    'errorCssClass' => 'error',
                    'action' => Url::toRoute(['phone']),
                    'options' => ['data-pjax' => true],
                ]); ?>
                <h2 class="small">Изменение номера телефона</h2>

                <div class="row">

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">текущий</div>
                                <div class="form-cell _txt-right">
                                    <?= $form->field($phone, 'username', ['template' => '<span>+7</span>{input}{error}', 'options' => ['class' => 'input-data phone']])->textInput(['disabled' => 'disabled'])->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell nowrap">новый номер*</div>
                                <div class="form-cell _txt-right">
                                    <?= $form->field($phone, 'new_username', ['template' => '<span>+7</span>{input}{error}', 'options' => ['class' => 'input-data phone']])->textInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fl-r">
                        <button class="btn green" onclick="MainManager.showModal('phone')">Отправить</button>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>
                <?php if($request_id) { ?>
                    <div class="modal fade" id="modal-request-success" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-content">
                                <?php $form = ActiveForm::begin([
                                    'id' => 'confirmphone-form',
                                    'errorCssClass' => 'hint',
                                    'action' => Url::toRoute(['confirmphone']),
                                    'options' => ['data-pjax' => true],
                                ]); ?>

                                    <h2>Подтвердите номер телефона</h2>

                                    <div class="form-grid">
                                        <div class="form-row">
                                            <div class="form-cell">Код</div>
                                            <div class="form-cell">
                                                <div class="input-data">
                                                    <?= Html::input('text', 'code', '') ?>
                                                    <?= Html::hiddenInput('request_id', $request_id) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="_txt-center">
                                        <?= Html::submitButton('Отправить', ['class' => 'btn green', 'name' => 'login-button']) ?>
                                    </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                <?php } else{ ?>
                <div class="modal fade" id="modal-request-success" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-content">
                                <h2>Ваш номер телефона успешно изменен.</h2>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php Pjax::end(); ?>

            </div>