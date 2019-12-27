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

$this->title = "Список заявок на звонок";


?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny default footable-loaded" data-page-size="15">
                    <thead>
                    <tr>

                        <th class="footable-visible footable-first-column footable-sortable">Имя<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Номер телефона<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone,tablet" class="footable-visible footable-sortable">Пользователь<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Статус<span class="footable-sort-indicator"></span></th>
                        <th data-hide="phone" class="footable-visible footable-sortable">Дата<span class="footable-sort-indicator"></span></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    /**
                     * @var \common\models\Order $callback
                     */

                    foreach ($callbacks as $callback) {  ?>
                    <tr class="footable-even" style="display: table-row;">
                        <td class="footable-visible footable-first-column"><span class="footable-toggle"></span>
                            <?=$callback->name?>
                        </td>
                        <td class="footable-visible">
                            <a href="callto:<?= $callback->phone ?>"><?=$callback->phone?></a>
                        </td>
                        <td class="footable-visible">
                            <?php if($callback->user) echo $callback->user->username; else echo 'Не авторизованный пользователь'; ?>
                        </td>
                        <td class="footable-visible">
                            <?= ($callback->active)?'<span class="badge badge-info">новый</span>':'<span class="badge badge-success">завершен</span>'; ?>
                        </td>
                        <td class="footable-visible">
                            <?=$callback->created_at?>
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
