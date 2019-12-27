<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 16/12/2016
 * Time: 01:42
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Url;


/* @var $this yii\web\View */


$this->title ='Акции';

$this->params['breadcrumbs'][] = "Акции";

$asset = \backend\assets\custom\PromoIndexAsset::register($this);

?>

<div class="row">

    <div class="col-lg-12 animated fadeInRight">



        <div class="row">
            <div class="col-lg-12">


                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Список акций</h5>
                        <div class="pull-right">
                            <a  class="btn btn-outline btn-primary btn-xs" href="<?=Url::toRoute(['add-item'])?>">
                                Добавить акцию
                            </a>
                        </div>

                    </div>
                    <div class="ibox-content">


                        <table class="table">
                            <thead>
                            <tr><th>#</th>
                                <th>Картика</th>
                                <th>Название</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody id="sortable">

                            <?php
                            /** @var \common\models\Promo $item */
                            foreach($promos as $item)  { ?>
                                <tr id="item_<?=$item->id?>" sort-id="<?=$item->id?>">
                                    <td><span class="label label-info dd-h"><i class="fa fa-list"></i></span></td>
                                    <td><?php if($item->uploadTo('file_name')) { ?><img width="50" height="50" src="<?=(new MyImagePublisher($item))->thumbnail(100,100)?>"> <?php } else echo "-"; ?></td>
                                    <td><?=$item->title?></td>
                                    <td>
                                        <a href="#" class="dell-catalog-item" data-item-id="<?=$item->id?>" data-item-name="<?=$item->title?>">Удалить</a> | <a href="<?=Url::toRoute(['edit','id'=>$item->id])?>">Изменить</a>
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




