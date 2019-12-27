<?php

use yii\widgets\Pjax;

?>
            <div class="cabinet-row">

            <?php Pjax::begin(['id' => 'follow', 'enablePushState' => false]); ?>
                <h2 class="small">Подписка</h2>

                <div class="row">

                    <div class="col col_2">
                        <div class="activate-box true" data-activate-input="2">
                            <div class="form-grid">
                                <div class="form-row">
                                    <div class="form-cell">e-mail*</div>
                                    <div class="form-cell">
                                        <div class="input-data activate">
                                            <input type="text" value="nikola@mail.ru">
                                            <button class="btn orange big" onclick="MainManager.staticActivate(2)">подписаться</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div data-activate-box="2" class="activate-box">
                        <button class="btn border fl-r m-b10" onclick="MainManager.staticActivate(2)">отменить подписку</button>
                        <p>nikola@mail.ru</p>
                        <p class="color">Вы подписаны на еженедельную рассылку новостей и акций компании «Пронто»</p>
                    </div>


                </div>
            <?php Pjax::end(); ?>

            </div>