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

$this->params['breadcrumbs'][] = "Добавить Модификатор";
$this->title ='Добавить Модификатор';

?>

<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content text-left p-md">

                <h2 class="text-center"><span class="text-success text-center">Добавить модификатор</span>
                </h2>

                <p>
                    <?php
                    $form = ActiveForm::begin(['id'=>'add-category', 'options' => ['enctype' => 'multipart/form-data']]);
                    ?>
                    <?= $form->field($addForm, 'title',array())->textInput() ?>
                    <?= $form->field($addForm, 'price',array())->textInput() ?>
                    <?= $form->field($addForm, 'ext_code',array())->textInput() ?>
                    <?= $form->field($addForm, 'icon',array())->textInput() ?>
                    <?= $form->field($addForm, 'video_link')->textInput() ?>
                    <?= $form->field($addForm, 'active')->checkbox() ?>
                    <?= $form->field($addForm, 'description',array())->textArea() ?>
                    
                    <div class="row crop-value">
                        <div class="col-md-12">
                            <?=\backend\widgets\crop\CropImageWidget::widget([
                                    'form'=>$addForm,
                                    'fileAttribute'=>'photo',
                                ]
                            )?>
                        </div>
                    </div>

                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>
