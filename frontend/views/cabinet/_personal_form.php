<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

?> 
            <div class="cabinet-row">
            <?php Pjax::begin(['id' => 'personnal', 'enablePushState' => false]); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'cabinet-personal-form',
                    'errorCssClass' => 'error',
                    'action' => Url::toRoute(['personal']),
                    'options' => ['data-pjax' => true],
                ]); ?>
                <h2 class="small">Личные данные</h2>

                <div class="row">

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">имя*</div>
                                <div class="form-cell">
                                    <?= $form->field($person, 'first_name', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">фамилия*</div>
                                <div class="form-cell">
                                    <?= $form->field($person, 'last_name', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col_2">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-cell">день рождения*</div>
                                <div class="form-cell">
                                    <?= $form->field($person, 'birthday', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">e-mail</div>
                                <div class="form-cell">
                                    <?= $form->field($person, 'email', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="fl-r">
                        <button class="btn green" onclick="MainManager.showAlert('personal')">сохранить</button>
                    </div>

                </div>
                <?php ActiveForm::end(); ?>
                <?php if($success) { ?>
                    <div class="modal fade" id="modal-personal-success" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
                            <div class="modal-content">
                                <h2>Ваши персональные данные успешно изменены.</h2>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php Pjax::end(); ?>

            </div>