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

                        <th class="footable-visible footable-first-column footable-sortable">Номер заказа<span class="footable-sort-indicator"></span></th>
                        <th class="footable-visible footable-first-column footable-sortable">Дата и время<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Клиент<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone,tablet" class="footable-visible footable-sortable">Адрес<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Сумма<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Статус заказа<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Оплата<span class="footable-sort-indicator"></span></th>
                        <th class="text-right footable-visible footable-last-column footable-sortable">Статус<span class="footable-sort-indicator"></span></th>
                        <th class="text-right footable-visible footable-last-column footable-sortable">Действия<span class="footable-sort-indicator"></span></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /**
                     * @var \common\models\Order $order
                     */

                    foreach ($orders as $order) {  ?>
                    <tr class="footable-even" style="display: table-row;">
                        <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                            <?=$order->id?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->created_at?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->getClientForBackend()?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->getAddressForBackend()?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->order_summ?>
                        </td>
                        <td class="footable-visible">
                            <?=$order->getStatus()?>
                        </td>
                        <td class="footable-visible">

                            <?php switch ($order->payment_type){

                                case \common\models\Order::PAYMENT_TYPE_CASH:{ ?>
                                    <span class="label label-primary">Наличные</span>
                                    <?php
                                }
                                break;

                                case \common\models\Order::PAYMENT_TYPE_CARD:{
                                    ?>
                                    <span class="label label-danger">Карта </span>
                                    <?php
                                }

                                    break;

                            }
                            ?>

                        </td>


                        <td class="footable-visible">
                            <?php switch ($order->payment_status){

                                case \common\models\Order::PAYMENT_STATUS_WAIT:{ ?>
                                    <span class="label">Ожидает оплаты</span>
                                    <?php
                                }
                                    break;

                                case \common\models\Order::PAYMENT_STATUS_BAD:{
                                    ?>
                                    <span class="label label-warning">Оплата не прошла </span>
                                    <?php
                                }

                                    break;
                                case \common\models\Order::PAYMENT_STATUS_PAID:{
                                    ?>
                                    <span class="label label-primary">Оплачен</span>
                                    <?php
                                }

                                    break;

                            }
                            ?>
                        </td>
                        <td class="text-right footable-visible footable-last-column">
                            <div class="btn-group">
                                <a href="<?=\yii\helpers\Url::toRoute(['view','id'=>$order->id])?>" class="btn-white btn btn-xs">Просмотр</a>
                            </div>
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
