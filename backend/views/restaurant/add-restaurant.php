<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use backend\assets\custom\AddRestaurantAsset;

/* @var $this yii\web\View */



$this->title = 'Добавить ресторан';
$this->params['breadcrumbs'][] = $this->title;

AddRestaurantAsset::register($this);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyD5UrANCl5Pqrg9F-oKmMCA9mxpbueXDOY&libraries=places&callback=initMap&language=en',[ 'depends' => 'backend\assets\custom\AddRestaurantAsset' ]);


?>
    <div class="row">
        <div class="col-md-8"><div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Ресторан</h5>

                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                            <div class="form-group"><label>Адрес ресторана</label>

                                <?=  $form->field($addForm, 'address',array( 'enableLabel'=>false))->textInput();?>
                                <?= $form->field($addForm, 'searchTitle',array('enableLabel'=>false))->textInput([ 'id'=>"pac-input" ,'class'=>"controls", 'type'=>"text", 'placeholder'=>"Search Box"])?>
                                <?php


                                echo Html::activeHiddenInput($addForm, 'lat'); //Field
                                echo Html::activeHiddenInput($addForm, 'lng'); //Field



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


                    <?= $form->field($addForm, 'metro',array())->textarea() ?>

                    <?= $form->field($addForm, 'phone',array())->textInput() ?>
                    <?= $form->field($addForm, 'external_id',array())->textInput() ?>
                    <?= $form->field($addForm, 'tags',array())->dropDownList(\common\models\Tag::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>
                    <?= $form->field($addForm, 'organisation',array())->dropDownList(\common\models\Organisation::getItemsForSelect()) ?>


                </div>
            </div></div>
    </div>

<?php ActiveForm::end(); ?>