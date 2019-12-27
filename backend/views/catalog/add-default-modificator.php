<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use common\models\CatalogItemModificatorCountLink;

$this->params['breadcrumbs'][] = "Добавить модификатор по умолчанию";
$this->title ='Добавить модификатор по умолчанию';

$asset = \backend\assets\custom\PromoFormAsset::register($this);
?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2 class="text-center">
                    <span class="text-success text-center">Добавить</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                    <?= $form->field($formItem, 'catalog_item_modificator_id')->dropDownList(CatalogItemModificatorCountLink::getItemsForSelect($formItem->catalog_item_id))->label('Модификатор') ?>
                    <?= $form->field($formItem, 'count')->textInput()->label('Количество') ?>

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>
            </div>
        </div>
    </div>

</div>
