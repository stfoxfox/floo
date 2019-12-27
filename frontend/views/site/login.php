<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'errorCssClass' => 'error',
                    'action' => Url::toRoute(['site/login'])
                ]); ?>

                    <h2>Вход</h2>

                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-cell">логин</div>
                            <div class="form-cell">
                                    <?= $form->field($login_model, 'username', ['options' => ['class' => 'input-data']])->textInput(['autofocus' => true])->label(false) ?>
                            </div>
                        </div>
                        <div class="form-row"> <!--add class error-->
                            <div class="form-cell">пароль</div>
                            <div class="form-cell">
                                    <?= $form->field($login_model, 'password', ['options' => ['class' => 'input-data']])->passwordInput()->label(false) ?>
                                    <!--div class="hint">Минимум 6 символов</div-->
                            </div>
                        </div>
                        <?php //$form->field($login_model, 'rememberMe')->checkbox() ?>
                    </div>

                    <div class="_txt-center">
                        <?= Html::submitButton('войти', ['class' => 'btn green', 'name' => 'login-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>