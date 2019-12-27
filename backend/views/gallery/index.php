<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 30/06/2017
 * Time: 21:36
 * @var \yii\web\View $this
 * @var \common\models\PageBlock $item
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


\backend\assets\custom\GalleryAsset::register($this);
$this->title = "Управление галереей";

?>


<div class="row">

    <div class="col-lg-8 col-lg-offset-2 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="pull-right">
                            <?php $form = ActiveForm::begin(['id' => 'upload-picture-form','enableClientScript'=>false,'options' => ['enctype' => 'multipart/form-data']]); ?>
                            <label title="Добавить изображение" for="inputImage" class="btn btn-xs btn-success">

                                <?php

                                $form->field($addPictureForm, 'file_name')->begin();


                                echo Html::activeFileInput($addPictureForm, 'file_name',array('accept'=>'image/*','id'=>"inputImage",'class'=>"hide")); //Field


                                $form->field($addPictureForm, 'file_name')->end();


                                ?>
                                Добавить изображение
                            </label>

                            <?php
                            echo Html::activeHiddenInput($addPictureForm, 'x'); //Field
                            echo Html::activeHiddenInput($addPictureForm, 'y'); //Field
                            echo Html::activeHiddenInput($addPictureForm, 'w'); //Field
                            echo Html::activeHiddenInput($addPictureForm, 'h'); //Field
                            echo Html::activeHiddenInput($addPictureForm, 'item_id'); //Field
                            echo Html::activeHiddenInput($addPictureForm, 'image_id'); //Field





                            ?>
                            <?php ActiveForm::end(); ?>


                        </div>
                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Изображение</th>
                                <th>текст</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php


                            foreach($items as $image)  { ?>
                                <tr id="item_<?=$image->id?>" sort-id="<?=$image->id?>" >
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>

                                    <td>
                                        <a class="galery_img" data-lightbox="roadtrip" href="<?=(new MyImagePublisher($image))->getOriginalImage()?>"><img alt="image" class="img-responsive" src="<?=(new MyImagePublisher($image))->MyThumbnail(100,100)?>"></a>
                                    <td>

                                        <a id="text_<?=$image->id?>" href="#" data-url="<?=Url::toRoute(['modificator/save-image-data'])?>"  data-block-id ="<?=$image->id?>"   data-emptytext="Текст" data-mode="inline"  data-type="textarea"  data-pk="<?=$image->id?>"  data-name="text" data-placement="right" data-placeholder="Текст"  class="editable editable-click item-settings myeditable save-item" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$image->text?></a>


                                        </td>

                                    <td><a href="#" class="edit-blog-item" data-picture-url="<?=(new MyImagePublisher($image))->getOriginalImage()?>" data-item-id="<?=$image->id?>">Изменить</a> |
                                        <a href="#" class="dell-blog-item" data-item-id="<?=$image->id?>" >Удалить</a>
                                    </td>

                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>




                    </div>
                </div>


            </div>
        </div>



    </div>
</div>


<div class="modal inmodal fade" id="cropper-example-2-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Обрезать фото</h4>
            </div>
            <div class="modal-body">
                <div id="cropper-example-2">
                    <img id="crop_img" height="300" width="300" src="" alt="Picture">
                </div>
            </div>
            <div class="modal-footer">


                <button type="button" class="btn btn-success" id="picture-done-button">Готово</button>

                <button type="button" class="btn btn-white" data-dismiss="modal">Отмена</button>

            </div>
        </div>
    </div>
</div>


