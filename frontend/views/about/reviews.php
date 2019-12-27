<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\widgets\LinkPager;

$this->title = 'Отзывы';

\frontend\assets\AboutAsset::register($this);
?>
	<div class="content page about-wr"> <!--если есть пагинатор то даем класс .page-->

        <div class="wrapper index about">

            <h1 class="title">Cады Cальвадора</h1>

            <h2 class="big for-mobile">Отзывы</h2>

            <div class="sort m-b50">
                ГЕНЕРАЛЬНЫЙ ДИРЕКТОР: Прохоров Андрей Николаевич
            </div>

            <!-- <div class="_txt-center m-b30">
                <a href="#send-review" class="btn pink big reviews-btn" >написать отзыв</a>
            </div> -->

            <?php

            /**
             * @var \common\models\BaseModels\ReviewBase $review
             */

            foreach ($reviews as $review) { ?>

                <div class="list-reviews">
                    <?=$review->review_text?>
                    <div class="name"><?=$review->name?></div>
                </div>

            <?php } ?>

            <?php

            echo LinkPager::widget([
                'pagination' => $pages,
                'nextPageLabel'=>'',
                'prevPageLabel'=>'',

                'options'=>['class' => 'paginate']
            ]);

            ?>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'vacancy-page__form form', 'enctype' => 'multipart/form-data']
            ]); ?>
            <div id="send-review" class="content-form vacancies-form">
                <h2 class="m-b30">Написать нам</h2>

                <div class="row">
                    <div class="col col_2">
                        <div class="form-grid">



                            <div class="form-row">
                                <div class="form-cell">имя</div>
                                <div class="form-cell">
                                    <div class="input-data">
                                        <?= $form->field($reviewForm, 'name', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">телефон</div>
                                <div class="form-cell _txt-right">
                                    <div class="input-data phone">
                                        <span>+7</span>
                                        <?= $form->field($reviewForm, 'phone', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>

                                        <!--div class="hint">Например +7 926 000 00 00</div-->
                                    </div>
                                </div>
                            </div>                            
                        </div>


                    </div>
                    <div class="col col_2">
                        <div class="textarea-box">
                            <div class="input-data">
                                <?= $form->field($reviewForm, 'review_text', ['options' => ['class' => 'input-data']])->label(false)->textarea() ?>

                                <!--div class="hint">Вы ввели какую то хрень</div-->
                            </div>
                            <div class="form-label">ваш отзыв</div>
                        </div>
                    </div>
                </div>
                <div class="_txt-center m-t10">
                    <button class="btn pink big">Отправить</button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>

    </div>