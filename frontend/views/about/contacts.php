<?php

use yii\helpers\Url;
$this->title = 'Контакты';

\frontend\assets\AboutAsset::register($this);
?>
	<div class="content about-wr">

        <div class="wrapper index about">

            <h1 class="title">пронто</h1>

            <h2 class="big for-mobile">Контакты</h2>

            <div class="sort m-b50">
                <a href="<?= Url::toRoute(['/delivery/index']) ?>">ДОСТАВКА</a> 
                <a href="<?= Url::toRoute(['/about/payment']) ?>">ОПЛАТА</a> 
                <a href="<?= Url::toRoute(['/restaurant/index']) ?>">ДЛЯ БИЗНЕСА</a> 
                <a href="<?= Url::toRoute(['/restaurant/view', 'id' => 1]) ?>">КОНТАКТЫ</a>
                <a href="<?= Url::toRoute(['/about/vacancies']) ?>">ВАКАНСИИ</a>
                <a href="<?= Url::toRoute(['/about/reviews']) ?>">ПИСЬМО ДИРЕКТОРУ</a>
            </div>

            <div class="main-phone">
                <p>+7 495/499 505-57-57</p>
                <p>+7 495 597–04–36</p>
            </div>

            <div class="_p8">
                <div class="row main-data">
                    <div class="col col_2">
                        <p>ООО «АВЕНО»</p>
                        <div>
                            <div class="p-color">Юридический адрес:</div>
                            142803, Московская область, Ступинский р-н,
                            г. Ступино, проспект Победы, д. 63а,
                            помещение № 3.07, этаж 3
                        </div>

                        <div>
                            <div class="p-color">Почтовый адрес:</div>
                            143005, Московская обл.,
                            г. Одинцово, Можайское ш., д. 159
                        </div>

                        <div>
                            <div class="p-color">Электронная почта:</div>
                            <a href="#">nfo@pronto24.ru</a>
                        </div>

                        <div>
                            <div class="p-color">Генеральный директор:</div>
                            Дергачева Ирина Григорьевна
                        </div>
                        <div>
                            <div class="p-color">Главный бухгалтер:</div>
                            Дергачева Ирина Григорьевна
                        </div>
                    </div>
                    <div class="col col_2">
                        <p>
                            ИНН/КПП 5045057060/504501001 <br>
                            ОГРН 1155045000384 <br>
                            ОКПО 59355773 <br>
                            ОКАТО 46253501000 <br>
                            ОКВЭД 55.30 <br>
                        </p>
                        <p>
                            Расчетный счет 40702810000000114349 <br>
                            в ПАО ВТБ 24 <br>
                            к/с 30101810100000000716 <br>
                            в ГУ Банка России по ЦФО <br>
                            БИК 044525716 <br>
                            ИНН 7710353606 <br>
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>