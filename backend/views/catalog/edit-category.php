<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 23:46
 */

use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ActiveForm;

$this->title ='Изменить категорию';



?>


<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2><span class="text-success">Изменить</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id'=>'add-category']);
                    ?>
                    <?= $form->field($editForm, 'title',array())->textInput() ?>
                    <?= $form->field($editForm, 'alias',array())->textInput() ?>
                    <?= $form->field($editForm, 'show_in_app',array())->checkbox() ?>
                    <?= $form->field($editForm, 'is_active',array())->checkbox() ?>
                    <?= $form->field($editForm, 'is_main_page',array())->checkbox() ?>

                    <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>

