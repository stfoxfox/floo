<?php

use frontend\assets\ChildrenAsset;
$children_asset = ChildrenAsset::register($this);
$this->title = 'Детское меню';

?>
    <div class="content children product children-style">

        <div class="section">
            <div class="intro">
                детское меню
            </div>
            <div class="wrapper">
                <div class="children-slider" data-children-slider>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/1.png" alt="">
                            <span  class="title icon-1">Салат<br>«Веселый огород»</span>
                        </a>
                        <div class="text-intro" data-height>
                            Огурец свежий, помидоры Черри
                            Бакинские, сметана, зелень укропа
                            и петрушки
                        </div>
                        <div class="rub">120 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/2.png" alt="">
                            <span  class="title icon-2">Куриные наггетсы<br>с картофелем фри</span>
                        </a>
                        <div class="text-intro" data-height>
                            Куриные окорочка, кляр, картофель фри,
                            паприка, кетчуп, соль
                        </div>
                        <div class="rub">170 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/3.png" alt="">
                            <span  class="title icon-3">Пельмени</span>
                        </a>
                        <div class="text-intro" data-height>
                            Пельмени, зелень укропа и петрушки,
                            сметана
                        </div>
                        <div class="rub">150 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/2.png" alt="">
                            <span  class="title icon-2">Куриные наггетсы<br>с картофелем фри</span>
                        </a>
                        <div class="text-intro" data-height>
                            Куриные окорочка, кляр, картофель фри,
                            паприка, кетчуп, соль
                        </div>
                        <div class="rub">170 руб.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section blue">
            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" width="100%" height="72px" viewBox="0 0 1978.7 98.6" >
                <path class="st0" d="M0,0v98.6h1978.7v-26C1323.6-148.9,656.8,254.9,0,0z"/>
            </svg>

            <div class="wrapper">
                <div class="children-slider" data-children-slider>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/4.png" alt="">
                            <span  class="title icon-4">Фарфале с куриным<br>филе и брокколи</span>
                        </a>
                        <div class="text-intro" data-height>
                            Паста Фарфале, куриные окорочка, брокколи,
                            масло сливочное, сливки, бульон куриный,
                            сыр Эдам, помидоры Черри, зелень укропа
                            и петрушки
                        </div>
                        <div class="rub">180 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/5.png" alt="">
                            <span  class="title icon-5">Куриный<br>супчик</span>
                        </a>
                        <div class="text-intro" data-height>
                            Куриные окорочка, лапша, морковь,
                            петрушка
                        </div>
                        <div class="rub">130 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/6.png" alt="">
                            <span  class="title icon-6">Шашлычки<br>из курицы</span>
                        </a>
                        <div class="text-intro" data-height>
                            Куриные окорочка, мед, соус соевый,
                            картофельное пюре, помидоры Черри,
                            кетчуп, зелень петрушки
                        </div>
                        <div class="rub">140 руб.</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="section purple">
            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" width="100%" height="72px" viewBox="0 0 1978.7 98.6" >
                <path class="st0" d="M0,72.6l0,26h1978.7l0-98.6C1321.9,254.9,655.1-148.9,0,72.6z"/>
            </svg>

            <div class="wrapper">
                <div class="children-slider" data-children-slider>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/7.png" alt="">
                            <span  class="title icon-7">Шашлычки<br>из семги </span>
                        </a>
                        <div class="text-intro" data-height>
                            Филе семги, мед, соус Тар-тар,
                            картофельное пюре, помидоры Черри,
                            кетчуп, зелень укропа
                        </div>
                        <div class="rub">220 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/8.png" alt="">
                            <span  class="title icon-8">Пицца<br>детская </span>
                        </a>
                        <div class="text-intro" data-height>
                            Тесто, пицца-Соус, сыр Моцарелла,
                            сосиски, маслины, перец болгарский,
                            помидоры Черри, зелень петрушки
                        </div>
                        <div class="rub">180 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/9.png" alt="">
                            <span  class="title icon-9">Бургер</span>
                        </a>
                        <div class="text-intro" data-height>
                            Котлета говяжья, булка, кетчуп Хайнц,
                            листья салата, помидор и огурец свежие,
                            картофель фри
                        </div>
                        <div class="rub">190 руб.</div>
                    </div>
                    <div class="item">
                        <a href="#" class="product-link">
                            <img src="<?= $children_asset->baseUrl; ?>/img/8.png" alt="">
                            <span  class="title icon-8">Пицца<br>детская </span>
                        </a>
                        <div class="text-intro" data-height>
                            Тесто, пицца-Соус, сыр Моцарелла,
                            сосиски, маслины, перец болгарский,
                            помидоры Черри, зелень петрушки
                        </div>
                        <div class="rub">180 руб.</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="section green">
            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" width="100%" height="72px" viewBox="0 0 1978.7 98.6" >
                <path class="st0" d="M0,0v98.6h1978.7v-26C1323.6-148.9,656.8,254.9,0,0z"/>
            </svg>

            <div class="wrapper">
                <div class="children-slider single" data-children-slider-single>
                    <div class="item">
                        <div class="grid icon">
                            <a href="#" class="product-link">
                                <span  class="title icon-10">Теплый<br>молочный коктейль</span>
                            </a>
                            <div class="text-intro">
                                Напиток премиум-класса без содержания
                                кофеина, приготовленный по фирменному
                                американскому рецепту
                            </div>

                            <div class="rub _t">Выбери свой вкус</div>
                            <p>Крем-карамель</p>
                            <p>Булочка с корицей</p>
                            <p>Молочная ириска</p>
                            <p>Шоколадный декаданс</p>

                            <div class="rub">220 руб.</div>
                        </div>

                        <div class="grid">
                            <img src="<?= $children_asset->baseUrl; ?>/img/10.png" alt="">
                        </div>

                    </div>
                    <div class="item">
                        <div class="grid icon">
                            <a href="#" class="product-link">
                                <span  class="title icon-10">Теплый<br>молочный коктейль</span>
                            </a>
                            <div class="text-intro">
                                Напиток премиум-класса без содержания
                                кофеина, приготовленный по фирменному
                                американскому рецепту
                            </div>

                            <div class="rub _t">Выбери свой вкус</div>
                            <p>Крем-карамель</p>
                            <p>Булочка с корицей</p>
                            <p>Молочная ириска</p>
                            <p>Шоколадный декаданс</p>

                            <div class="rub">220 руб.</div>
                        </div>

                        <div class="grid">
                            <img src="<?= $children_asset->baseUrl; ?>/img/10.png" alt="">
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="section white">
            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" width="100%" height="72px" viewBox="0 0 1978.7 98.6" >
                <path class="st0" d="M0,72.6l0,26h1978.7l0-98.6C1321.9,254.9,655.1-148.9,0,72.6z"/>
            </svg>

            <div class="wrapper">
                <div class="_txt-center">
                    <h3>PRONTO PIZZA рада Вас приветствовать в наших кафе!</h3>
                    <p>
                        Вы прекрасно сможете отдохнуть и насладиться изысканной итальянской кухней. <br>
                        Во время Вашего отдыха ваше чадо будет проводить время с пользой и удовольствием в "Pronto Kids club"!
                    </p>
                    <p>
                        Каждые выходные, в субботу и воскресенье вас ждут детские праздники с разной тематикой и задумкой.
                        К нам приходят сказочные герои из популярных современных мультиков и сказок. Запутанные приключения, волшебные испытания, конкурсы и фокусы – всё, что обожают дети, будет их ждать в «Пронто» по выходным –
                        приходите сами и приводите своих друзей!
                    </p>
                </div>
                <div class="grid-box">
                    <div class="row">
                        <div class="col col_3c">
                            <p class="p-color big">День рождения в кафе «Пронто» </p>
                            <p>
                                С детским клубом в «Пронто» вы можете больше не ломать голову, где провести день рождения вашего ребенка . У нас есть различные программы, ориентированные на возраст гостей и их вкусовые пристрастия. Душевные аниматоры, радушный прием, музыка, интересные конкурсы, аквагрим, моделирование из шаров – всё это входит в программу детского праздника в кафе «Пронто». Дополнительно Вашему вниманию можем предложить кукольный театр, ростовых кукол, оформление шарами, фокусника, шоу мыльных пузырей, веселых сказочных героев в мастерской волшебника их более 300.
                                А ещё – у нас постоянно проходят акции, которые непременно вас порадуют!
                            </p>
                            <p>
                                При заказе детского дня рождения в «Пронто» на будний день,  при заказе любого из четырех праздничных пакетов – <span class="s-color">шар Сюрприз №1 в подарок!</span> Это фейерверк из мелких воздушных шариков и конфетти, который доставляет детям шквал эмоций!
                            </p>
                            <p>
                                Для наших гостей мы всегда готовы предложить бонусы и подарки ко дню рождения.
                                Все эти приятные моменты и детали праздничных программ уточняйте у администраторов.
                            </p>
                        </div>
                        <div class="col col_3">
                            <p class="p-color big">Школа юного Пиццайоло и кондитера</p>
                            <p>
                                Каждую Субботу мы ждем вас и вашего ребенка в "Школе юного Пиццайоло и кондитера"! Это увлекательные кулинарные уроки для самых маленьких и их родителей. Ваш ребенок приготовит СВОЮ, уникальную пиццу и другие блюда! Ему выдадут одежду настоящего Пиццайоло! Все уроки проводятся весело и легко - ребенок не будет скучать и станет настоящим детским поваром, его даже наградят дипломом! Для этого нужно посетить весь "курс" кулинарных мастер-классов, состоящий из 5 уроков.
                            </p>
                            <p>
                                Подробности  и стоимость уточняйте.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="_txt-center small">
                    <p class="p-color big">Чем мы порадуем Вас в будние дни?</p>
                    <p>
                        Интересными и увлекательными занятиями для детей от 2 лет! <br>
                        Пока родители наслаждаются нашей итальянской кухней, дети осваивают следующие направления:
                    </p>
                </div>

                <div class="row small m-b20">
                    <div class="col col_2">
                        <b>Набор в группу детей от 3-6 лет:</b>
                        <ol>
                            <li>Общее развитие (обогащение словарного запаса ребенка
                            в игровой форме, а также развитие коммуникативных навыков).</li>
                            <li>Английский язык для детей ( в игровой форме).</li>
                            <li>Творчество (развитие творческих способностей, воображения).</li>
                            <li>Песочная анимация ( развитие мелкой моторики от 3 лет).</li>
                            <li>Школа Юного поваренка.</li>
                            <li>Беби фитнес - комплекс упражнений на равновесие,
                            координацию движений и развитие внимания.</li>
                        </ol>
                    </div>
                    <div class="col col_2">
                        <b>Набор в группу детей от 5-7 лет</b>
                        <ol>
                            <li>Интересная подготовка к школе (чтение, логика, окружающий
                            мир, в игровой форме).</li>
                            <li>Беби театр  - театральная студия ( развитие воображения,
                            внимания, памяти).</li>
                            <li>Песочная анимация.</li>
                            <li>Гончарная мастерская.</li>
                            <li>Беби - фитнес( хореография).</li>
                            <li>Школа юного поваренка.</li>
                        </ol>
                    </div>
                </div>

                <div class="_txt-center">
                    <p class="small m-b40">В каждой группе не более 4-5 человек. Занятия платные. Расписание и цену уточняйте у администраторов ресторана.</p>

                    <h3>
                        Мы делаем всё для того, <br>
                        чтобы вам захотелось прийти к нам снова и снова!
                    </h3>
                </div>


            </div>


        </div>

        <div class="section _txt-center orange">
            <div class="wrapper">
                <h3 class="m-b50">Детский игровой центр есть в данных ресторанах:</h3>
                <div class="res-list m-b20">
                    <div>
                        м. Коломенское, <br>
                        ул. Новинки, 12Б<br>
                        8 (499) 725–12–69
                    </div>
                    <div>
                        м. Свиблово, ул.<br>
                        Енисейская, 5/2<br>
                        8 (499) 760-00-15
                    </div>
                    <div>
                        г. Королев, пр–т<br>
                        Космонавтов, 12А<br>
                        8 (495) 519–27–69
                    </div>
                    <div>
                        г. Реутов, ул. Южная,<br>
                        10А, ТЦ «Курс»<br>
                        8 (495) 508–82–22
                    </div>
                    <div>
                        г. Красногорск,<br>
                        Павшинский б-р, 16<br>
                        8 (926) 116-04-43
                    </div>
                    <div>
                        г. Зеленоград,<br>
                        мкр–н 15, корп. 1549<br>
                        8 (499) 733-04-22
                    </div>
                    <div>
                        г. Одинцово,<br>
                        Можайское шоссе,<br>
                        159, ТЦ "Курс"
                    </div>
                </div>
                <h3 class="_l"><a href="#">Все рестораны «Пронто»</a></h3>
            </div>
        </div>


    </div>