<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:15
 */

/* @var $this yii\web\View */


use common\components\MyExtensions\MyImagePublisher;
use common\models\CatalogItemModificator;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\Url;
use backend\assets\custom\ModificatorsAsset;

$asset = ModificatorsAsset::register($this);

$this->params['breadcrumbs'][] = "Управление Модификаторами";
$this->title ='Управление Модификаторами';

?>


<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список модификаторов</h5>
                        <div class="pull-right">
                            <a class="btn btn-outline btn-primary btn-xs" href="<?=Url::to(['index', 'sort' => 'name'])?>">
                                Сортировка А/Я
                            </a>
                            <a class="btn btn-outline btn-primary btn-xs" href="<?=Url::to(['index', 'sort' => 'active'])?>">
                                Сначала активные
                            </a>
                            <a class="btn btn-outline btn-primary btn-xs" id="set-active" href="#">
                                Сделать все активными
                            </a>
                            <a class="btn btn-outline btn-danger btn-xs" id="set-inactive" href="#">
                                Сделать все неактивными
                            </a>
                            <a class="btn btn-outline btn-danger btn-xs" href="<?=Url::to(['index', 'sort' => 'inactive'])?>">
                                Показать неактивные
                            </a>
                            <a class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add-item'])?>">
                                Добавить Модификатор
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Картика</th>
                                <th>Код</th>
                                <th>Активен</th>
                                <th>Фотография</th>
                                <th>Описание</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var CatalogItemModificator $item */
                            foreach($modificatorsList as $item)  { ?>
                                <tr id="item_<?=$item->id?>" sort-id="<?=$item->id?>">
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                    <td><a href="#" id="item-title" data-type="text" data-url="<?=Url::toRoute(['modificator/item-edit-title'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Название" data-title="Название" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->title?></a></td>
                                    <td><a href="#" id="item-price" data-type="text" data-url="<?=Url::toRoute(['modificator/item-edit-price'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Цена" data-title="Цена" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->price?></a></td>
                                    <td><a href="#" id="item-icon" data-type="text" data-url="<?=Url::toRoute(['modificator/item-edit-icon'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Иконка" data-title="Иконка" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->icon?></a></td>
                                    <td><a href="#" id="item-code" data-type="text" data-url="<?=Url::toRoute(['modificator/item-edit-ext-code'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Код юпитера" data-title="Код юпитера" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->ext_code?></a></td>
                                    <td><a href="#" id="item-active" data-source="[{value: 0, text: 'Нет'}, {value: 1, text: 'Да'}]" data-type="select" data-url="<?=Url::toRoute(['modificator/item-edit-active'])?>" data-pk="<?=$item->id?>" data-placement="right" data-placeholder="Активен" data-title="Активен" class="editable editable-click item-price" data-original-title="" title="" style="background-color: rgba(0, 0, 0, 0);"><?=$item->active ? 'Да' : 'Нет'?></a></td>
                                    <td>
                                    <?php
                                    $item->file_name = $item->photo;
                                    if($item->uploadTo('photo')) { ?><img width="50" height="50" src="<?=(new MyImagePublisher($item))->thumbnail(100,100)?>"> <?php } else echo "-"; 
                                    ?>
                                    </td>
                                    <td><?= $item->description ?></td>
                                    <td>
                                        <a href="#" class="dell-catalog-item" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title?>">delete</a> | <a href="<?=Url::toRoute(['edit-item','id'=>$item->id])?>">Изменить</a>
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


