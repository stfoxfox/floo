<?php

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title ='Модификаторы по умолчанию';

$this->params['breadcrumbs'][] = "Меню";
$asset = \backend\assets\custom\CatalogModificatorAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список модификаторов</h5>
                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add-default-modificator', 'id' => $id ])?>">
                                Добавить
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Название</th>
                                <th>Количество</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">
                            <?php
                            /** @var \common\models\Promo $item */
                            foreach($items as $item)  { ?>
                                <tr>
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                    <td><?=$item->catalogItemModificator->title?></td>
                                    <td><?=$item->count?></td>
                                    <td>
                                        <a href="#" class="dell-modificator" data-catalog-item-id="<?=$item->catalog_item_id?>" data-modificator-id="<?=$item->catalog_item_modificator_id?>">Удалить</a> | 
                                        <a href="<?=Url::toRoute(['edit-default-modificator','catalogItemID' => $item->catalog_item_id, 'modificatorID' => $item->catalog_item_modificator_id])?>">Изменить</a>
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




