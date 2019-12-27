<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 29/11/2016
 * Time: 00:28
 */

$this->params['breadcrumbs'][] ="Управление ресторанами";

$this->title="Управление ресторанами";

use common\models\CatalogItemModificator;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use backend\assets\custom\RestaurantAsset;

$asset = RestaurantAsset::register($this);

?>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">
                    <?php



                    ?>

                    <div class="hr-line-dashed"></div>
                    <h5>Регионы</h5>

                    <ul class="folder-list" style="padding: 0" id="folder_list">

                        <?php


                        foreach($regions as $region){
                            ?>
                            <li sort-id="<?=$region->id?>" id="cat_<?=$region->id?>" <?php if($region->id == $selectedRegion->id) echo "class='text-bold'"; ?>><a id="#a-cat-<?=$region->id?>" href="<?=Url::toRoute(['view','id'=>$region->id])?>"><i class="fa fa-folder"></i> <?=$region->title?><span data-cat="<?=$region->id?>" data-cat_name="<?=$region->title?>" class="label label-info pull-right cat_dell">x</span></a></li>


                        <?php }  ?>



                    </ul>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="#" id="createCategory"><i class="fa fa-plus"></i> Добавить регион</a></li>
                    </ul>
















                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Регион: <?=$selectedRegion->title?></h5>
                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['restaurant/add','region_id' => $selectedRegion->id])?>">
                                Добавить ресторан
                            </a>
                            <button type="button" class="btn  btn-outline btn-xs btn-success" id="edit-category" data-category-title="<?=$selectedRegion->title?>" data-category-id="<?=$selectedRegion->id?>">Изменить регион</button>

                        </div>

                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Адрес</th>
                                <th>Телефон</th>
                                <th>Активен</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var \common\models\Restaurant $item */
                            foreach($selectedRegion->restaurants as $item)  { ?>
                                <tr id="item_<?=$item->id?>" sort-id="<?=$item->id?>" data-cat="<?=$selectedRegion->id?>">
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                     <td><?=$item->address?></td>
                                    <td><?=$item->phone?></td>
                                    <td><?=$item->is_active?></td>

                                    <td><a href="<?=Url::toRoute(['restaurant/edit','id'=>$item->id])?>" class="edit-catalog-item" >изменить</a> |
                                        <a href="#" class="dell-catalog-item" data-item-id="<?=$item->id?>" data-item-name="<?=$item->address?>">Удалить</a>
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
