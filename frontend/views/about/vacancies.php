<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Вакансии';

\frontend\assets\AboutAsset::register($this);
?>
	<div class="content about-wr">

        <div class="wrapper index about">


            <h1 class="title">Вакансии</h1>

            <h2 class="big for-mobile">Вакансии</h2>

            <table class="base small m-b25">

                <?php foreach ($vacancies as $vacancy) {

                    ?>
                    <tr>
                        <td><?=$vacancy->title?></td>
                        <td><?=$vacancy->getRestaurantsList()?></td>
                    </tr>

                <?php

                } ?>


            </table>

            
            <div class="p-color big">
                Требования к соискателям:
            </div>
            <ul class="m-b40">
                <li>гражданство РФ;</li>
                <li>коммуникабельность, энергичность, вежливость, честность, инициативность,</li>
                <li>умение работать в команде;</li>
                <li>желание работать, расти и развиваться вместе с нами.</li>
            </ul>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'vacancy-page__form form', 'enctype' => 'multipart/form-data']
            ]); ?>
            <div class="content-form vacancies-form">
                <h2 class="m-b30">Написать нам</h2>
                <div class="row">
                    <div class="col col_2">
                        <div class="form-grid">



                            <div class="form-row">
                                <div class="form-cell">имя</div>
                                <div class="form-cell">
                                    <div class="input-data">
                                        <?= $form->field($vForm, 'name', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">телефон</div>
                                <div class="form-cell _txt-right">
                                    <div class="input-data phone">
                                        <span>+7</span>
                                        <?= $form->field($vForm, 'phone', ['options' => ['class' => 'input-data']])->textInput()->label(false) ?>

                                        <!--div class="hint">Например +7 926 000 00 00</div-->
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-cell">вакансия</div>
                                <div class="form-cell">
                                    <div class="input-data">

                                        <?= $form->field($vForm, 'vacancy_id', ['options' => ['class' => 'selessctpicker']])->label(false)
                                            ->dropDownList(\common\models\Vacancy::getItemsForSelect(),['class' => 'selectpicker']) ?>



                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col col_2">
                        <div class="textarea-box">
                            <div class="input-data">
                                <?= $form->field($vForm, 'comment', ['options' => ['class' => 'input-data']])->label(false)->textarea() ?>

                                <!--div class="hint">Вы ввели какую то хрень</div-->
                            </div>
                            <div class="form-label">ваш комментарий</div>
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