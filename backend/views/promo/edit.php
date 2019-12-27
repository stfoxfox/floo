<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:29
 */

/* @var $this yii\web\View */

use common\components\MyExtensions\MyImagePublisher;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;

$this->params['breadcrumbs'][] = "Изменить Акцию";
$this->title ='Изменить Акцию';

$asset = \backend\assets\custom\PromoFormAsset::register($this);
?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2 class="text-center"><span class="text-success text-center">Добавить Акцию</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                    <?= $form->field($editForm, 'title',array())->textInput() ?>
                    <?= $form->field($editForm, 'description',array())->textarea() ?>
                    <?= $form->field($editForm, 'description_short',array())->textarea() ?>
                    <?= $form->field($editForm, 'discount',array())->textInput() ?>
                    <?= $form->field($editForm, 'min_order',array())->textInput() ?>
                    <?= $form->field($editForm, 'action_type',array())->dropDownList(\common\models\Promo::getAttributeEnums('ACTION_TYPE')) ?>
                    <?= $form->field($editForm, 'for_all_restaurants')->checkbox() ?>
                    <?= $form->field($editForm, 'restaurants_array',array())->dropDownList(\common\models\Restaurant::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r select2','id'=>"select-types","style"=>"width: 100%"]) ?>
                    <?= $form->field($editForm, 'items_array',array())->dropDownList(\common\models\CatalogItem::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r select2','id'=>"select-types","style"=>"width: 100%"]) ?>
                    <?= $form->field($editForm, 'site_id',array())->dropDownList(\common\models\ExternalSite::getItemsForSelect(),['prompt'=>"Подключить к сайту",'class'=>'form-control m-r select2','id'=>"select-types","style"=>"width: 100%"]) ?>


                <div class="col-md-12">

                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Картинка акции</h5>
                            <div class="pull-right">

                                <label title="Add Picture" for="promoform-file_name" class="btn btn-outline btn-xs btn-success">

                                    <?php

                                    $form->field($editForm, 'file_name')->begin();


                                    echo Html::activeFileInput($editForm, 'file_name',array('accept'=>'image/*','class'=>"hide")); //Field


                                    $form->field($editForm, 'file_name')->end();


                                    ?>
                                    Добавить фото
                                </label>

                                <?php
                                echo Html::activeHiddenInput($editForm, 'x'); //Field
                                echo Html::activeHiddenInput($editForm, 'y'); //Field
                                echo Html::activeHiddenInput($editForm, 'w'); //Field
                                echo Html::activeHiddenInput($editForm, 'h'); //Field





                                ?>




                            </div>

                        </div>
                        <div class="ibox-content">

                            <div class="m-t m-b"  id="image-div" ><img  id="crop_img" width="300" src="<?=(new MyImagePublisher($item))->resizeInBox(300,300)?>" alt="Picture"></div>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">


                            <?=\backend\widgets\crop\CropImageWidget::widget([

                                    'form'=>$editForm,
                                    'fileAttribute'=>'site_banner_fine_name',
                                    'model'=>$item,
                                    'ratio'=>3.76
                                ]


                            )?>


                        </div>
                    </div>

                </div>


                <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                <?php ActiveForm::end(); ?>



            </div>
        </div>
    </div>

</div>
