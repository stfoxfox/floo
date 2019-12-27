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

$this->params['breadcrumbs'][] = "Изменить Модификатор";
$this->title ='Изменить Модификатор';

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
                    <?= $form->field($editForm, 'title',array())->textInput() ?>
                    <?= $form->field($editForm, 'price',array())->textInput() ?>
                    <?= $form->field($editForm, 'ext_code',array())->textInput() ?>
                    <?= $form->field($editForm, 'icon',array())->textInput() ?>
                    <?= $form->field($editForm, 'video_link',array())->textInput() ?>
                    <?= $form->field($editForm, 'active')->checkbox() ?>
                    <?= $form->field($editForm, 'description',array())->textArea() ?>

                    <div class="btn-group">
                        <a href="<?=Url::toRoute(['manage-gallery','id'=>$item->id])?>" class="btn btn-white" type="button">Управление галереей</a>
                    </div>
                    
                    <div class="row crop-value">
                        <div class="col-md-12">
                            <?=\backend\widgets\crop\CropImageWidget::widget([
                                    'form'=>$editForm,
                                    'fileAttribute'=>'photo',
                                    'model'=> $item
                                ]
                            )?>
                        </div>
                    </div>

                    <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-success', 'name' => 'add-type-button']) ?>

                    <?php ActiveForm::end(); ?>
                </p>

            </div>
        </div>
    </div>

</div>
