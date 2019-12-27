<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 22/06/2017
 * Time: 13:19
 *
 * @var \yii\web\View $this
 */

use yii\widgets\LinkPager;

$this->title = "Список заказов";


?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny default footable-loaded" data-page-size="15">
                    <thead>
                    <tr>

                        <th class="footable-visible footable-first-column footable-sortable">Номер отзыва<span class="footable-sort-indicator"></span></th>
                        <th class="footable-visible footable-first-column footable-sortable">Дата и время<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Ресторан<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">имя<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone,tablet" class="footable-visible footable-sortable">телефон<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">текст<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">статус<span class="footable-sort-indicator"></span></th>
                        <th class="text-right footable-visible footable-last-column footable-sortable">Действия<span class="footable-sort-indicator"></span></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /**
                     * @var \common\models\BaseModels\ReviewBase $order
                     */

                    foreach ($orders as $order) {  ?>
                    <tr class="footable-even" style="display: table-row;">
                        <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                            <?=$order->id?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->updated_at?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->restaurant->address?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->name?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->phone?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->review_text?>
                        </td>


                        <td class="footable-visible">
                            <?php if (!$order->is_active){


                                    ?>
                                    <a href="<?=\yii\helpers\Url::toRoute(['set-status','id'=>$order->id])?>" class="label label-warning">Не опубликован </a>
                                    <?php
                                }

                                  else{
                                    ?>
                                    <a href="<?=\yii\helpers\Url::toRoute(['set-status','id'=>$order->id])?>" class="label label-primary">Опубликован</a>
                                    <?php
                                }


                            ?>
                        </td>

                    </tr>

                    <?php } ?>




                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="10" class="footable-visible">

                            <?php

                            echo LinkPager::widget([
                                'pagination' => $pages,
                                'options'=>['class' => 'pagination pull-right']
                            ]);

                            ?>
                                 </td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
