<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 07.08.15
 * Time: 18:17
 */
use common\models\CatalogItem;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\assets\custom\CatalogAsset;
use common\models\CatalogCategory;
use common\models\SpotCatalogItem;
use \common\components\MyExtensions\MyImagePublisher;
$asset = CatalogAsset::register($this);

/**
 * @var CatalogCategory $category
 * @var $this yii\web\View
 */

$this->title ='Управление Меню';



    $cat_id=0;
    $this->params['breadcrumbs'][] = "Управление Меню";


?>

<div class="row">
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="file-manager">
                    <div class="hr-line-dashed"></div>
                    <h5>Категории</h5>
                    <ul class="folder-list" style="padding: 0" id="folder_list">
                    <?php foreach($CatalogCategories as $cat) { ?>
                        <li sort-id="<?=$cat->id?>" id="cat_<?=$cat->id?>" <?php if($cat->id == $category->id) echo "class='text-bold'"; ?>><a id="#a-cat-<?=$cat->id?>" href="<?=Url::toRoute(['view','id'=>$cat->id])?>"><i class="fa fa-folder"></i> <?=$cat->title?><span data-cat="<?=$cat->id?>" data-cat_name="<?=$cat->title?>" class="label label-info pull-right cat_dell">x</span></a></li>
                    <?php }  ?>
                    </ul>

                    <ul class="folder-list" style="padding: 0">
                        <li><a href="<?= Url::toRoute(['catalog/unavailable'])?>">Недоступные букеты</a></li>
                    </ul>
                    
                    <ul class="folder-list" style="padding: 0">
                        <li><a href="#"  id="createCategory"><i class="fa fa-plus"></i> Добавить категорию</a></li>
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
                        <h5>Катерия: <?=$category->title?></h5>
                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add-item','id'=>$category->id])?>">
                               Добавить блюдо
                            </a>
                            <a class="btn  btn-outline btn-xs btn-success" href="<?=Url::toRoute(['edit-category','id'=>$category->id])?>">Изменить категорию</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Фото</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var CatalogItem $menuItem */

                            $items = $category->getCatalogItems()->orderBy('sort')->all();
                            foreach($items as $menuItem)  { ?>
                                <tr id="item_<?=$menuItem->id?>" sort-id="<?=$menuItem->id?>" data-cat="<?=$cat_id?>">
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                    <td><?php if($menuItem->uploadTo('file_name')) { ?><img width="50" height="50" src="<?=(new MyImagePublisher($menuItem))->thumbnail(100,100)?>"> <?php } else echo "-"; ?></td>
                                    <td><?=$menuItem->title?></td>
                                    <td><a href="#" id="item-price" data-type="text" data-url="<?=Url::toRoute(['catalog/item-edit-price'])?>" data-pk="<?=$menuItem->id?>" data-placement="right" data-placeholder="price" data-title="Item price" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$menuItem->price?></a></td>

                                    <td><a href="<?=Url::toRoute(['edit-item','id'=>$menuItem->id])?>">edit</a> |
                                        <a href="#" class="dell-catalog-item" data-item-id="<?=$menuItem->id?>" data-item-name="<?=$menuItem->title?>">delete</a>
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


<div class="modal inmodal fade" id="edit-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">


        </div>
    </div>
</div>

