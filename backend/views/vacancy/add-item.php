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

$this->params['breadcrumbs'][] = "Добавить вакансию";
$this->title ='Добавить вакансию';

$asset = \backend\assets\custom\PromoFormAsset::register($this);
?>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2 class="text-center"><span class="text-success text-center">Добавить вакансию</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id' => 'add-spot', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


                    <?= $form->field($addForm, 'title',array())->textInput() ?>
                    <?= $form->field($addForm, 'description',array())->textarea() ?>
                    <?= $form->field($addForm, 'restaurants_array',array())->dropDownList(\common\models\Restaurant::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r select2','id'=>"select-types","style"=>"width: 100%"]) ?>





                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>



            </div>
        </div>
    </div>

</div>
