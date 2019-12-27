<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:29
 */

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

$this->params['breadcrumbs'][] = "Изменить организацию";
$this->title ='Изменить организацию';

?>

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2 class="text-center"><span class="text-success text-center">Изменить организацию</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id'=>'add-category']);
                    ?>
                    <?= $form->field($editForm, 'title',array())->textInput() ?>
                    <?= $form->field($editForm, 'sber_login',array())->textInput() ?>
                    <?= $form->field($editForm, 'sber_pass',array())->textInput() ?>
                    <?= $form->field($editForm, 'platron_login',array())->textInput() ?>
                    <?= $form->field($editForm, 'platron_pass',array())->textInput() ?>

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>
