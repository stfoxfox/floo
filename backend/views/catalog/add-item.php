<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24/11/2016
 * Time: 00:32
 */

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use \yii\helpers\Url;
use backend\assets\custom\ItemFormAsset;

$asset = ItemFormAsset::register($this);
?>

<?php $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


<div class="row">

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Основная информация</h5>

            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">




                        <?= $form->field($addForm, 'title')->textInput() ?>
                        <?= $form->field($addForm, 'description')->textarea() ?>

                            <?php // $form->field($editForm, 'types',array())->dropDownList(\common\models\SpotType::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>

                            <?= $form->field($addForm, 'price')->textInput() ?>
                            <?= $form->field($addForm, 'ext_code')->textInput() ?>
                            <?= $form->field($addForm, 'packing_weights')->textInput() ?>

                            <?= $form->field($addForm, 'category_id')->dropDownList(\common\models\CatalogCategory::getItemsForSelect()) ?>

                            <?= $form->field($addForm, 'css_class')->dropDownList(\backend\models\forms\CatalogItemForm::CSS_CLASSES, ['prompt' => 'Выберите иконку']) ?>

                            <?= $form->field($addForm, 'active')->checkbox() ?>

                            <?= $form->field($addForm, 'is_main_page')->checkbox() ?>

                            <?= $form->field($addForm, 'in_basket_page')->checkbox() ?>
                        </div>

                    </div>
                </div>



            </div>
        </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Дополнительная информация для пиццы</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">




                                <?= $form->field($addForm, 'price_st_st')->textInput() ?>
                                <?= $form->field($addForm, 'ext_code_st_st')->textInput() ?>

                                <?= $form->field($addForm, 'price_big_st')->textInput() ?>
                                <?= $form->field($addForm, 'ext_code_big_st')->textInput() ?>

                                <?= $form->field($addForm, 'price_st_big')->textInput() ?>
                                <?= $form->field($addForm, 'ext_code_st_big')->textInput() ?>

                                    <?= $form->field($addForm, 'price_big_big')->textInput() ?>
                                <?= $form->field($addForm, 'ext_code_big_big')->textInput() ?>


                            </div>

                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Save', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Фотография блюда</h5>
                <div class="pull-right">

                    <label title="Add Picture" for="catalogitemform-file_name" class="btn btn-outline btn-xs btn-success">

                        <?php

                        $form->field($addForm, 'file_name')->begin();


                        echo Html::activeFileInput($addForm, 'file_name',array('accept'=>'image/*','class'=>"hide")); //Field


                        $form->field($addForm, 'file_name')->end();


                        ?>
                        Добавить фото
                    </label>

                    <?php
                    echo Html::activeHiddenInput($addForm, 'x'); //Field
                    echo Html::activeHiddenInput($addForm, 'y'); //Field
                    echo Html::activeHiddenInput($addForm, 'w'); //Field
                    echo Html::activeHiddenInput($addForm, 'h'); //Field





                    ?>




                </div>

            </div>
            <div class="ibox-content">

                <div class="m-t m-b" style="display: none;" id="image-div" ><img id="crop_img" height="300" width="300" src="" alt="Picture"></div>


            </div>
        </div>



    </div>
    <div class="col-md-3">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Дополнительные данные</h5>

            </div>
            <div class="ibox-content">


                <?= $form->field($addForm, 'modificators',array())->dropDownList(\common\models\CatalogItemModificator::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>

                <?=$form->field($addForm,'add_all_modificators')->checkbox()?>
                <?= $form->field($addForm, 'tags',array())->dropDownList(\common\models\Tag::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-tags","style"=>"width: 100%"]) ?>


            </div>
        </div>



    </div>

</div>
<?php ActiveForm::end(); ?>