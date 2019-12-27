<?php

/* @var $this yii\web\View */
use common\components\MyExtensions\MyImagePublisher;
use common\components\MyExtensions\MyHelper;
use yii\helpers\Url;
use frontend\assets\MainAsset;
use frontend\assets\StockAsset;
use common\models\Setting;

$this->title = Setting::getValueByKey('index_title')?  Setting::getValueByKey('index_title'):'САДЫ САЛЬВАДОРА | Заказ и доставка цветов и букетов по Москве. Заказать доставку букетов цветов на дом, в офис.';
\Yii::$app->view->registerMetaTag([
    'name' => 'description',
    'content' =>  Setting::getValueByKey('index_desc') ?  Setting::getValueByKey('index_desc'):'САДЫ САЛЬВАДОРА - заказ и доставка цветов и букетов по Москве. Сделайте заказ цветов и отправьте букет своим любимым прямо сейчас!'
]);

\Yii::$app->view->registerMetaTag([
    'name' => 'keywords',
    'content' => Setting::getValueByKey('index_keywords') ?  Setting::getValueByKey('index_keywords'):'доставка цветов, заказ цветов, москва, заказать, отправить, доставка букетов'
]);
$main_asset = MainAsset::register($this);
$stock_asset = StockAsset::register($this);

?>
    <h1 style=" margin-top: 30px;"><?= Setting::getValueByKey('tag_h1')?></h1>
    <div class="content">

        <!--Parallax for main page-->
        <ul id="parallax-bottom" class="parallax bottom">
            <li class="layer _1" data-depth="0.02"><div class="background"></div></li>
            <li class="layer _2" data-depth="0.15"><div class="wrapper"><div class="background"></div></div></li>
        </ul>
        <div class = "category"></div>
        <div class="wrapper index product pizza main-style">

                <!-- <div class="intro">
                    <span>итальянская</span>
                    <div>Пицца</div>
                    <span>на&nbsp;тонком&nbsp;тесте</span>
                </div> -->

                <!--row for 3 columns-->
                <div class="row row-col">
                <?php foreach ($pizza as $index => $item) { ?>
                    <div class="col col_3 basket-catalogItem-id" data-id="<?= $item->id; ?>">
                        <a href="<?= Url::toRoute(['/menu/product', 'id' => $item->id]) ?>" class="product-link">
                            <img src="<?=(new MyImagePublisher($item))->MyThumbnail(600,600)?>" alt="<?= $item->title ?>">
                            <span class="title icon-<?= $item->css_class; ?>"><?= $item->title; ?></span>
                        </a>

                        <?php if(!empty($item->price_st_st)){?>


                        <div class="set dropup btn-group row">
                            <div class="btn border set-btn">
                                <?= $item->price_big_st; ?> руб.
                            </div>
                            <a style="text-decoration: none;" href="<?= Url::toRoute(['/menu/product', 'id' => $item->id]) ?>" class="btn pink set-btn">
                                Заказать
                            </a>
                        </div>
                        <?php }else{ ?>
                        <div class="set row">
                            <div class="set-col">

                                <div class="gr"></div>

                                <div class="btn-group number-group">
                                    <button data-btn-number="" type="button" class="btn border btn-number" data-type="minus"></button>
                                    <input data-input-number="" type="text" name="" class="btn border input-number basket-catalogItem-count" value="1" min="1" readonly="">
                                    <button data-btn-number="" type="button" class="btn border btn-number" data-type="plus"></button>
                                </div>

                            </div>

                            <div class="set-col">                              

                                <button class="btn pink small basket-catalogItem-addtocart">
                                    в корзину
                                </button>

                            </div>

                        </div>
                        <?php }?>

                    </div>
                    


                <?php if((int)(($index+4) % 3) == 0) { ?>
                </div>

                <!--row for 3 columns-->
                <div class="row row-col">
                <?php } ?>
                <?php } ?>





                </div>

                <div class="_txt-center">
                  <a href="<?= Url::toRoute(['/menu/all']) ?>"  id="show_more_pizza" class="btn more">Смотреть все</a>
                </div>

        </div>

    </div>
    
    <div class="section">
        <div class="wrapper index">
            <div class="stock row">
                <?php foreach ($stocks as $item) { ?>
                <a href="<?= Url::toRoute(['/stock/view', 'id' => $item->id]) ?>"><img src="<?=(new MyImagePublisher($item))->MyThumbnail(300,142)?>" alt="<?= $item->title ?>"></a>
                <?php } ?>
            </div>
            <div class="delivery">

                <div class="title">
                    <h2><?= Setting::getValueByKey('tag_h2') ?></h2>
                </div>

                <div class="row">
                    <div class="col col_4">
                        Букеты дня
                        (цветы, готовые к немедленной доставке)
                    </div>
                    <div class="col col_4">
                        Бесплатный комплимент 
                        (амулеты из полудрагоценных камней в подарок)
                    </div>
                    <div class="col col_4">
                        Бесплатная открытка 
                        (элегантные открытки к каждому букету)
                    </div>
                    <div class="col col_4">
                        Оплата талантами (мы принимаем валюту системы PRAVDA*)
                    </div>
                    
                </div>
                <span class="title-pravda">* планируемый запуск системы PRAVDA - март 2018 года</span>
            </div>
        </div>       
    </div>
</div>
<div class="title-pravda text-justify">
    <div class="wrapper">
        <?= MyHelper::formatTextToHTML(Setting::getValueByKey('text_footer')) ?>
    </div>
</div>