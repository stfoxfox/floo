<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24/11/2016
 * Time: 00:32
 */

/* @var $this yii\web\View */

use common\components\MyExtensions\MyImagePublisher;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use backend\assets\custom\ItemFormAsset;

$asset = ItemFormAsset::register($this);

/**
 * @var \common\models\CatalogItem $item
 */
$this->title = $item->title;

    $cat_id=$item->category_id;
    $this->params['breadcrumbs'][] =  ['label' => "Управление Меню", 'url' => ['view']];


$this->params['breadcrumbs'][] =  ['label' => $item->category->title, 'url' => ['view','id'=>$item->category_id]];


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
                        <?= $form->field($editForm, 'title')->textInput() ?>
                        <?= $form->field($editForm, 'description')->textarea() ?>

                            <?php // $form->field($editForm, 'types',array())->dropDownList(\common\models\SpotType::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>

                            <?= $form->field($editForm, 'price')->textInput() ?>
                            <?= $form->field($editForm, 'ext_code')->textInput() ?>
                            <?= $form->field($editForm, 'packing_weights')->textInput() ?>

                            <?= $form->field($editForm, 'category_id')->dropDownList(\common\models\CatalogCategory::getItemsForSelect()) ?>

                            <?= $form->field($editForm, 'css_class')->dropDownList(\backend\models\forms\CatalogItemForm::CSS_CLASSES, ['prompt' => 'Выберите иконку']) ?>

                            <?= $form->field($editForm, 'active')->checkbox() ?>

                            <?= $form->field($editForm, 'is_main_page')->checkbox() ?>

                            <?= $form->field($editForm, 'in_basket_page')->checkbox() ?>

                            <div class="btn-group">
                                <a href="<?=Url::toRoute(['/catalog/view-default-modificator','id' => $item->id])?>" class="btn btn-white" type="button">Управление модификаторами по умолчанию</a>
                            </div>
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




                                <?= $form->field($editForm, 'price_st_st')->textInput() ?>
                                <?= $form->field($editForm, 'ext_code_st_st')->textInput() ?>

                                <?= $form->field($editForm, 'price_big_st')->textInput() ?>
                                <?= $form->field($editForm, 'ext_code_big_st')->textInput() ?>

                                <?= $form->field($editForm, 'price_st_big')->textInput() ?>
                                <?= $form->field($editForm, 'ext_code_st_big')->textInput() ?>

                                    <?= $form->field($editForm, 'price_big_big')->textInput() ?>
                                <?= $form->field($editForm, 'ext_code_big_big')->textInput() ?>


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

                    <label title="Изменить фото" for="catalogitemform-file_name" class="btn btn-outline btn-xs btn-success">

                        <?php

                        $form->field($editForm, 'file_name')->begin();


                        echo Html::activeFileInput($editForm, 'file_name',array('accept'=>'image/*','class'=>"hide")); //Field


                        $form->field($editForm, 'file_name')->end();


                        ?>
                         Изменить фото
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
                
                <div class="m-t m-b" id="image-div" ><img id="crop_img" height="300" width="300" src="<?=(new MyImagePublisher($item))->thumbnail(512,512)?>" alt="Picture"></div>


            </div>
        </div>



    </div>
    <div class="col-md-3">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Дополнительные данные</h5>

            </div>
            <div class="ibox-content">


                <?= $form->field($editForm, 'modificators',array())->dropDownList(\common\models\CatalogItemModificator::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>
                <?=$form->field($editForm,'add_all_modificators')->checkbox()?>
                <?= $form->field($editForm, 'tags',array())->dropDownList(\common\models\Tag::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-tags","style"=>"width: 100%"]) ?>


            </div>
        </div>



    </div>

</div>
<?php ActiveForm::end(); ?>