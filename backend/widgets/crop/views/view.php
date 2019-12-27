<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/08/2017
 * Time: 14:01
 * @var \backend\widgets\crop\CropImageWidget $widget
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\BaseHtml;
use yii\helpers\Html;

$form = $widget->form;

$item= $widget->model;

$attribute =$widget->fileAttribute;
?>


<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?=$form->getAttributeLabel($attribute)?></h5>
        <div class="pull-right">

            <label title="Изменить изображение" for="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>" class="btn btn-outline btn-xs btn-success ">

                <?php




                echo Html::activeFileInput($form, $widget->fileAttribute,array('accept'=>'image/*','class'=>"hide input_file")); //Field





                ?>
                Изменить изображение
            </label>

            <?php
            echo Html::activeHiddenInput($form, $widget->x_field); //Field
            echo Html::activeHiddenInput($form, $widget->y_field); //Field
            echo Html::activeHiddenInput($form, $widget->w_field); //Field
            echo Html::activeHiddenInput($form, $widget->h_field); //Field





            ?>




        </div>

    </div>
    <div class="ibox-content">

        <?php if($item) {

            ?>



            <?php if (!$item->$attribute) {  ?>
                <div class="m-t m-b" style="display: none;" id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_image-div" ><img id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_crop_img" height="300" width="300" src="" alt="Picture"></div>
            <?php } else { ?>

                <div class="m-t m-b" id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_image-div" ><img id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_crop_img"  width="300" src="<?=(new MyImagePublisher($item))->resizeInBox(500,500,false,$attribute)?>" alt="Picture"></div>

            <?php } ?>


 <?php       }
        else { ?>

            <div class="m-t m-b" style="display: none;" id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_image-div" ><img id="<?=BaseHtml::getInputId($form,$widget->fileAttribute)?>_crop_img" height="300" width="300" src="" alt="Picture"></div>

        <?php } ?>


    </div>
</div>
