<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(['id' => 'login-form', 'class'=>"m-t"]); ?>
    <div class="form-group">
        <?= $form->field($model, 'username',array('enableLabel'=>false))->textInput(array('placeholder'=>"Username",'class'=>"form-control")) ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'password',array('enableLabel'=>false))->passwordInput(array('placeholder'=>"Password",'class'=>"form-control")) ?>


    </div>
    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

<?php ActiveForm::end(); ?>
