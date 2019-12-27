<?php

use backend\assets\custom\EditRestaurantAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

/* @var $this yii\web\View */



$this->title = 'Изменить ресторан';
$this->params['breadcrumbs'][] = $this->title;

EditRestaurantAsset::register($this);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyD5UrANCl5Pqrg9F-oKmMCA9mxpbueXDOY&libraries=places&callback=initMap&language=en',[ 'depends' => 'backend\assets\custom\EditRestaurantAsset' ]);


?>
    <div class="row">
    
        <div class="col-md-4"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Ресторан</h5>

                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin(['id' => 'add-restaurant', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                            <div class="form-group"><label>Адрес ресторана</label>

                                <?=  $form->field($editForm, 'address',array( 'enableLabel'=>false))->textInput();?>
                                <?= $form->field($editForm, 'searchTitle',array('enableLabel'=>false))->textInput([ 'id'=>"pac-input" ,'class'=>"controls", 'type'=>"text", 'placeholder'=>"Search Box"])?>
                                <?php


                                echo Html::activeHiddenInput($editForm, 'lat'); //Field
                                echo Html::activeHiddenInput($editForm, 'lng'); //Field



                                ?>



                                <div id="map" class="google-map"></div>

                            </div>


                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Next step', ['class' => 'btn btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div></div>
        <div class="col-md-4"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Additional info</h5>

                </div>
                <div class="ibox-content">


                    <?= $form->field($editForm, 'metro',array())->textarea() ?>

                    <?= $form->field($editForm, 'phone',array())->textInput() ?>
                    <?= $form->field($editForm, 'external_id',array())->textInput() ?>
                    <?= $form->field($editForm, 'tags',array())->dropDownList(\common\models\Tag::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>
                    <?= $form->field($editForm, 'organisation',array())->dropDownList(\common\models\Organisation::getItemsForSelect()) ?>
                    <?= $form->field($editForm, 'region_id',array())->dropDownList(\common\models\Region::getItemsForSelect()) ?>


                </div>
            </div></div>
    <div class="col-md-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Часы работы</h5>
            </div>
            <div class="ibox-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>День недели</th>
                            <th>Ресторан</th>
                            <th>Доставка</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    /**
                     * @var \common\models\WorkingDays $workingDay
                     */
                    foreach($workingDays as $workingDay) {
                    ?>
                        <tr>
                            <td><?=Yii::t('app/spot',"day_".$workingDay->weekday)?></td>
                            <td><a data-restaurant="<?=$workingDay->restaurant_id?>" data-day="<?=$workingDay->weekday?>" href="#" class="rh-editable-start" id="rh-hours-start-<?=$workingDay->weekday?>"><?=$workingDay->getRestaurantHours()['hours']['start']?></a> - <a data-restaurant="<?=$workingDay->restaurant_id?>" data-day="<?=$workingDay->weekday?>" class="rh-editable-stop" href="#" id="rh-hours-stop-<?=$workingDay->weekday?>"><?=$workingDay->getRestaurantHours()['hours']['stop']?></a></td>
                            <td><a data-restaurant="<?=$workingDay->restaurant_id?>" data-day="<?=$workingDay->weekday?>" href="#" class="dh-editable-start" id="dh-hours-start-<?=$workingDay->weekday?>"><?=$workingDay->getDeliveryHours()['hours']['start']?></a> - <a  data-restaurant="<?=$workingDay->restaurant_id?>" data-day="<?=$workingDay->weekday?>" class="dh-editable-stop" href="#" id="dh-hours-stop-<?=$workingDay->weekday?>"><?=$workingDay->getDeliveryHours()['hours']['stop']?></a></td>
                        </tr>
                    <?php
                    } 
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--  restaurant-zone -->
    <div class="col-md-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Зоны доставки</h5>
                <div>
                    <div class="pull-right">
                        <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['restaurant-zone/add', 'restaurant' => $restaurant->id])?>">
                            Добавить зону доставки
                        </a>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    /**
                     * @var \common\models\RestaurantZone $restaurantZone
                     */
                    foreach($restaurantZone as $zone) {
                    ?>
                        <tr>
                            <td><?= 'Зона '.$zone->id ?></td>
                            <td>
                                <a href="<?= Url::toRoute(['restaurant-zone/edit', 'id' => $zone->id])?>" class="edit-zone-item" data-item-id="<?=$zone->id?>" data-item-name="<?=$zone->id?>">Изменить</a> | 
                                <a href="#" class="dell-zone-item" data-item-id="<?=$zone->id?>" data-item-name="<?=$zone->id?>">Удалить</a>
                            </td>
                        </tr>
                    <?php
                    } 
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

<?php ActiveForm::end(); ?>
