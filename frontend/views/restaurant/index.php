<?php

use yii\helpers\Url;
use common\components\MyExtensions\MyImagePublisher;
$this->title = 'САДЫ САЛЬВАДОРА | Контакты';

\frontend\assets\RestaurantAsset::register($this);
$url = $this->assetManager->getPublishedUrl('@frontend/assets/app');
?>
    <div class="content restaurant all">


        <div class="wrapper">

            <h2 class="big">Сады Сальвадора</h2>

            <div class="sort sub m-b40">
                <?php foreach ($regions as $region) { ?>
                <a href="<?= Url::toRoute(['index', 'city_id' => $region->id]) ?>" class="<?= ($city && $city->id == $region->id)?'active':''; ?>"><?= $region->title ?></a>
                <?php } ?>
            </div>


          <!--  <div class="filters _txt-right m-b10 set-pills">
                <button data-children class="btn border m-r4">pronto kids</button>
                <button data-music class="btn border m-r4">живая музыка</button>
                <button data-lunch class="btn border m-r4">бизнес-ланч</button>
                <button data-banquet class="btn border m-r4">банкеты</button>
                <button data-all class="btn border active">все</button>
            </div>
            -->
            <div class="row">
                <!-- <div class="col col_3"> -->
                    <div class="restaurant-ul" data-restaurant-ul>

                        <?php foreach ($model as $index => $restaurant) { ?>

                            <div class="restaurant-list children">
                                <a href="<?= Url::toRoute(['view', 'id' => $restaurant->id]) ?>">

                                    <?= $restaurant->address; ?>
                                </a>
                            </div>


                        <?php } ?>



                    </div>


                <!-- </div> -->
                <!-- <div class="col col_3c"> -->
                    <div id="map" class="map"></div>
                <!-- </div> -->
            </div>



            <script>


                var point_url = "<?=$url?>/img/point.png";
                function points() {
                    var points = [

                        <?php
                        /**
                         * @var \common\models\Restaurant $restaurant
                         */
                        foreach ($model as $index => $restaurant) {

                            echo "{id: {$restaurant->id}, geo: [{$restaurant->lat},{$restaurant->lng}]},";

                  } ?>



                    ];
                    return points;
                }

                function children_points() {
                    var points = [
                        {id: "otradnoe", geo: [55.870646889253,37.590434167984]},
                        {id: "sviblovo", geo: [55.859957374864,37.659153415344]},
                        {id: "kolomenskoe", geo: [55.67597944634,37.678723390213]},
                    ];
                    return points;
                }

                function banquet_points() {
                    var points = [
                        {id: "sviblovo",geo: [55.859957374864,37.659153415344]},
                        {id: "semenovskaya",geo: [55.781714306896,37.71954768196]},
                        {id: "kolomenskoe",geo: [55.67597944634,37.678723390213]},
                    ];
                    return points;
                }

                function lunch_points() {
                    var points = [
                        {id: "vodnyy-stadion",geo: [55.839748031757,37.48817035582]},
                        {id: "sviblovo",geo: [55.859957374864,37.659153415344]},
                        {id: "semenovskaya",geo: [55.781714306896,37.71954768196]},
                        {id: "taganskaya",geo: [55.740593283655,37.658155733336]},
                    ];
                    return points;
                }

                function music_points() {
                    var points = [
                        {id: "semenovskaya",geo: [55.781714306896,37.71954768196]},
                    ];
                    return points;
                }

                function center() {


                    return   <?="[{$model[0]->lat},{$model[0]->lng}]"?>;
                }

                function zoom() {
                    return 15;
                }
            </script>


            <!-- <div class="img-bg"></div> -->
            <div class="con">
                <div class="index product product-style">   
                    <!--row for 3 columns-->
                    <div class="row row-col">
                    <?php foreach ($images as $index => $item) {?>
                        <div class="col col_3 basket-catalogItem-id" data-id="<?=$item->id;?>">
                            <a href="#" class="product-link">
                                <img src="<?=(new MyImagePublisher($item))->MyThumbnail(600, 600)?>" alt="<?=$item->text?>">
                                <span  class="title icon"><?=$item->text;?></span>
                            </a>
                                            
                        </div>            
                    <?php if ((int) (($index + 4) % 3) == 0) {?>
                    </div>

                    <!--row for 3 columns-->
                    <div class="row row-col">
                    <?php }?>
                    <?php }?>
                    </div>
                </div>
            </div> 
            <div class="_txt-center">
                <p>Компания Сады Сальвадора более 17 лет предоставляет услуги по доставке цветов по городу Москве. </p>
                <p>Мы предлагаем корпоративное обслуживание компаниям, заинтересованным в повышении лояльности сотрудников, улучшении позиционирования своего бренда, налаживании и укреплении отношений с партнерами и клиентами.</p>
                <p>Мы также оформляем корпоративные, свадебные и VIP-мероприятия, декорируем офисные помещения и интерьеры отелей.</p>
                <p>Создаем флористический дизайн в ресторанах, кафе и барах для проведения в них банкетов, концертов и других праздничных мероприятий.</p>
                <p>Сады Сальвадора разрабатывают фирменный цветочный стиль компании. Создание фирменных цветочных композиций – очень актуальная в настоящее время услуга. Они используются для оформления корпоративных мероприятий и являются оригинальными бизнес-подарками.
                </p>
            </div>
            <div class="_txt-left">
                <p>Возможно сотрудничество как на договорной так и бездоговорной основе</p>
                <p>- Индивидуальные скидки на все наши услуги</p>
                <p>- Отчетность по проделанной работе</p>
                <p>- Индивидуальное обслуживание</p>
                <p>- Возможность оплаты заказов по безналичному расчету</p>
                <p>- Ведение Календаря Дат Вашей Компании персональным менеджером</p>
                <p>- Специальные предложения, акции к праздникам, доступные только корпоративным клиентам</p>
                <p>Договор можно скачать здесь  </p>
                <p>Наши реквизиты:</p>
                <table class="table-contact">
                    <tbody>
                        <tr>
                            <td>Наименование организации</td>
                            <td>ООО "С-Гарденс"</td>
                        </tr>
                        <tr>
                            <td>Генеральный директор</td>
                            <td>Прохоров Андрей Николаевич</td>
                        </tr>
                        <tr>
                            <td>Юридический адрес</td>
                            <td>119019, Москва, Никитский бульвар 25</td>
                        </tr>
                        <tr>
                            <td>Фактический адрес</td>
                            <td>119019, Москва, Никитский бульвар 25, салон “Сады Сальвадора”</td>
                        </tr>
                        <tr>
                            <td>ИНН</td>
                            <td>7703824798</td>
                        </tr>
                        <tr>
                            <td>КПП</td>
                            <td>770301001</td>
                        </tr>
                        <tr>
                            <td>ОГРН</td>
                            <td>1157746000840</td>
                        </tr>
                        <tr>
                            <td>ОКПО</td>
                            <td>11298178</td>
                        </tr>
                        <tr>
                            <td>Расчетный счет</td>
                            <td>40702810238000022459</td>
                        </tr>
                        <tr>
                            <td>Корреспондентский счет</td>
                            <td>30101810400000000225</td>
                        </tr>
                        <tr>
                            <td>БИК</td>
                            <td>044525225</td>
                        </tr>
                        <tr>
                            <td>Банк</td>
                            <td>ПАО «Сбербанк» г.Москва</td>
                        </tr>
                        <tr>
                            <td>Регистрация в ПФР</td>
                            <td>14.05.2015 №087-103-131646</td>
                        </tr>
                        <tr>
                            <td>Регистрация в ФСС</td>
                            <td>РН №7736048769, код подразделения 7736</td>
                        </tr>
                    </tbody>
                </table>
                <p>
                <p>Наши телефоны: +7 495 933-28-49, +7 964 505-79-59 (WhatsApp, Viber, Telegram)</p>
                <p>Электронная почта: nikitsky@salvadorgardens.ru</p>
            </div>

        </div>

    </div>

    
          