<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 14:02
 */

$this->title ='Настройки сайта';

$this->params['breadcrumbs'][] = "Настройки сайта";

$asset = \backend\assets\custom\SiteSettingsAsset::register($this);

?>


<div class="row">
    <div class="col-lg-4 animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">

                    <?php



                    ?>

                    <div class="hr-line-dashed"></div>
                    <h5>Теги</h5>

                    <ul class="folder-list" style="padding: 0" id="folder_list">

                        <?php

                        foreach($tags as $tag){
                            ?>
                            <li sort-id="<?=$tag->id?>" id="cat_<?=$tag->id?>" ><a><i class="fa fa-folder"></i> <?=$tag->tag?><span data-cat="<?=$tag->id?>" data-cat_name="<?=$tag->tag?>" class="label label-info pull-right cat_dell">x</span></a></li>


                        <?php }  ?>



                    </ul>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="#"  id="createCategory"><i class="fa fa-plus"></i> Добавить тег</a></li>
                    </ul>
















                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">

                    <?php



                    ?>

                    <div class="hr-line-dashed"></div>
                    <h5>Организации</h5>

                    <ul class="folder-list" style="padding: 0" id="organisations_list">

                        <?php

                        foreach($organisations as $organisation){
                            ?>
                            <li  id="org_<?=$organisation->id?>" ><a href="<?=\yii\helpers\Url::toRoute(['edit-organisation','id'=>$organisation->id])?>"><i class="fa fa-folder"></i> <?=$organisation->title?><span data-cat="<?=$organisation->id?>" data-cat_name="<?=$organisation->title?>" class="label label-info pull-right dell_organisation">x</span></a></li>


                        <?php }  ?>



                    </ul>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="#"  id="createOrganisation"><i class="fa fa-plus"></i> Добавить организацию</a></li>
                    </ul>
















                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>


