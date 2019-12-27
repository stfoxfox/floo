<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use yii\helpers\Json;
use backend\assets\custom\RestaurantZoneAsset;

/* @var $this yii\web\View */



$this->title = 'Изменить зону доставку';
$this->params['breadcrumbs'][] = $this->title;

RestaurantZoneAsset::register($this);
?>
<div class="row">
    <div class="col-md-8"><div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Зона доставки</h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>
                        <div id="map" class="yandex-map"></div>
                        <?= $form->field($editForm, 'zone')->hiddenInput()->label(false) ?>
                        <?= $form->field($editForm, 'min_order')->textInput() ?>
                        <?= $form->field($editForm, 'min_time')->textInput() ?>
                        <?= $form->field($editForm, 'max_time')->textInput() ?>   
                        <?= $form->field($editForm, 'zone_external_id')->textInput() ?>                       
                        
                        <?= Html::submitButton('Изменить', [
                                'class' => 'btn btn-sm btn-primary pull-right m-t-n-xs', 
                                'name' => 'add-exist-button',
                                'id' => 'add-restaurant-zone'
                            ]) 
                        ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>