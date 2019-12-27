<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

?> 
            <div class="cabinet-row">
            <?php Pjax::begin(['id' => 'password', 'enablePushState' => false]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'cabinet-passwoed-form',
                    'errorCssClass' => 'error',
                    'action' => Url::toRoute(['password']),
                    'options' => ['data-pjax' => true],
                ]); ?>
                <h2 class="small">Изменение пароля</h2>

                <div class="row">

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">старый пароль</div>
                                <div class="form-cell">
                                    <?= $form->field($password, 'password', ['options' => ['class' => 'input-data']])->passwordInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">новый пароль*</div>
                                <div class="form-cell">
                                    <?= $form->field($password, 'new_password', ['template' => '{input}<div class="hint">Минимум 4 символов</div>{error}', 'options' => ['class' => 'input-data']])->passwordInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fl-r">
                        <button class="btn green">сохранить</button>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>
                <?php if(!$error) { ?>
                    <div class="modal fade" id="modal-password-success" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-content">
                                <h2>Ваш пароль успешно изменен.</h2>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php Pjax::end(); ?>

            </div>