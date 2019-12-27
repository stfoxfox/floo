<?php

use yii\widgets\Pjax;

?>
            <div class="cabinet-row">

            <?php Pjax::begin(['id' => 'discount', 'enablePushState' => false]); ?>
                <h2 class="small">Дисконтная карта</h2>

                <div class="row">

                    <div class="col col_2">
                        <div class="activate-box true" data-activate-input="1">
                            <div class="form-grid">
                                <div class="form-row">
                                    <div class="form-cell">номер*</div>
                                    <div class="form-cell">
                                        <div class="input-data activate">
                                            <input type="text" value="4568 7689 3456 2110">
                                            <button class="btn orange big" onclick="MainManager.staticActivate(1)">активировать</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-activate-box="1" class="activate-box">
                        <button class="btn border fl-r m-b10" onclick="MainManager.staticActivate(1)">изменить</button>
                        <p>4568 7689 3456 2110</p>
                        <p class="color">Ваша карта предоставляет вам скидку 5%</p>
                    </div>


                </div>
            <?php Pjax::end(); ?>

            </div>