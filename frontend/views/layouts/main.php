<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widget\Menu;
use frontend\assets\MainAsset;
use common\models\CatalogCategory;
use common\models\Setting;
use common\components\MyExtensions\MyImagePublisher;

$asset = MainAsset::register($this);

/**
 * @var CatalogCategory $category
 */
// $category =  CatalogCategory::find()->where(['alias'=>'pizza'])->one();
// $pizza_count = \common\models\CartItem::find()->where(['catalog_item_id'=>$category->getCatalogItems()->select(['id'])->asArray()])->andWhere(['>=','created_at', date('Y-m-d')])->count();

/**
 * @var \common\models\User $user
 */
$user = Yii::$app->user->identity;



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter47643778 = new Ya.Metrika({ id:47643778, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/47643778" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

    <div class="back" data-back></div>

    <!--Parallax for main page-->
    <ul id="parallax" class="parallax top">
        <li class="layer _1" data-depth="0.1">
            <div class="wrapper">
                <div class="background"></div>
            </div>
        </li>
        <li class="layer _2" data-depth="0.15">
            <div class="wrapper">
                <div class="background"></div>
            </div>
        </li>
    </ul>

    <!--fixed row-->
    <div data-row-fixed class="fixed">
        <div class="btn-group">
            <?php

            if (!isset($this->params['site_id']) ||  $this->params['site_id'] ==-1) {


                if(Yii::$app->user->isGuest) { ?>
            <button class="btn border" onclick="MainManager.showModalById('modal-registration')">регистрация</button>
            <button class="btn border" onclick="MainManager.showModalById('modal-authorization')">войти</button>
            <?php } else { ?>
            <a href="<?= Url::toRoute(['/cabinet/index']) ?>" class="btn border"><?=($user->last_name)? $user->name." ".$user->last_name:Yii::$app->user->identity->username ?></a>
            <a href="<?= Url::toRoute(['/site/logout']) ?>" onclick="return false;" class="btn border" data-method="post">Выход</a>
            <?php } } ?>
        </div>
        <div class="basket-box" onclick="MainManager.basket(1)">
            <button class="btn border" onclick="MainManager.basket(1)">В корзину</button>
            <?php 
                $summary_price = 0;
                $summary_count = 0;
                $id = null;
                $cookies = \Yii::$app->request->cookies;
                if (isset($cookies['cart']) && $cookies['cart']->value) {
                    $id =  $cookies['cart']->value;
                    $cart = \common\models\Cart::find()->where(['id' => $id]);
                    if($cart->exists()){
                        $cart = $cart->one();
                        $cart_items = $cart->cartItems;
                        
                        foreach ($cart_items as $cart_item) {
                            $summary_count += $cart_item->count;
                            $summary_price += $cart_item->sum;
                        }
                    }
                }
            ?>
            <span class="data"><span class="for-mobile">Корзина: </span><span class="basket-summary-count"><?= $summary_count ?></span> товаров — <span class="basket-summary-price"><?= $summary_price ?></span> руб.</span>
        </div>
    </div>

    <div class="wrapper index">

        <div class="header row">

            <div class="left-col">
                <a href="/" class="logo"></a>
                <button class="btn orange-bg" onclick="MainManager.showModalById('modal-callback')">заказать звонок</button>
            </div>

            <div class="right-col">
                <div class="main-nav row">
                    <div class="right-col">
                        <a href="tel:+74959332849" class="phone">+7 495 <span>933-28-49</span></a>

                        

                    </div>
                    <ul class="nav" data-main-menu>

                        <?php

                         if (!isset($this->params['site_id']) ||  $this->params['site_id'] ==-1) {



                            if(Yii::$app->user->isGuest) { ?>

                            <li class="for-mobile"><a href="#" onclick="MainManager.showModalById('modal-authorization'); return false;">войти</a></li>
                            <li class="for-mobile"><a href="#" onclick="MainManager.showModalById('modal-registration'); return false;">регистрация</a></li>

                        <?php } else { ?>

                            <li class="for-mobile"><a href="<?= Url::toRoute(['/cabinet/index']) ?>"><?=($user->last_name)? $user->name." ".$user->last_name:Yii::$app->user->identity->username ?></a></li>

                        <?php }


                        }
                        ?>

                        <li><a href="<?= Url::toRoute(['/delivery/index']) ?>">ДОСТАВКА</a></li> <li class="sep"></li>
                        <li><a href="<?= Url::toRoute(['/about/payment']) ?>">ОПЛАТА</a></li> <li class="sep"></li>
                        <li><a href="<?= Url::toRoute(['/restaurant/index']) ?>">ДЛЯ БИЗНЕСА</a></li> <li class="sep"></li>
                        <li><a href="<?= Url::toRoute(['/restaurant/view', 'id' => 1]) ?>">КОНТАКТЫ</a></li><li class="sep"></li>
                        <li><a href="<?= Url::toRoute(['/about/vacancies']) ?>">ВАКАНСИИ</a></li><li class="sep"></li>
                        <li><a href="<?= Url::toRoute(['/about/reviews']) ?>">ПИСЬМО ДИРЕКТОРУ</a></li>

                        <li class="for-mobile _s">
                            <div class="social">
                                <div><a href="https://api.whatsapp.com/send?phone=79645057959" target="_blank" ><i class="fa fa-whatsapp fa whatsapp-menu"></i></a></div>
                                <div><a href="https://www.instagram.com/salvadorgardens/?hl=ru" class="soc-icon-s_4" target="_blank"></a></div>
                            </div>
                        </li>

                    </ul>
                </div>

                <div class="_txt-center row">
                    <div class="btn-group">
                        <?php

                        if (!isset($this->params['site_id']) ||  $this->params['site_id'] ==-1) {


                        if(Yii::$app->user->isGuest) { ?>
                        <button class="btn border" onclick="MainManager.showModalById('modal-registration')">регистрация</button>
                        <button class="btn border" onclick="MainManager.showModalById('modal-authorization')">войти</button>
                        <?php } else { ?>
                        <a href="<?= Url::toRoute(['/cabinet/index']) ?>" class="btn border"><?=($user->last_name)? $user->name." ".$user->last_name:Yii::$app->user->identity->username ?></a>
                        <a href="<?= Url::toRoute(['/site/logout']) ?>" onclick="return false;" class="btn border" data-method="post">Выход</a>
                        <?php }  }?>
                    </div>
                    <div class="social">
                        <a href="https://api.whatsapp.com/send?phone=79645057959" rel="nofollow" target="_blank" class="fa fa-whatsapp fa-2x"></a>
                       <a href="https://www.instagram.com/salvadorgardens/?hl=ru"  target="_blank" class="soc-icon-s_4"></a>
                    </div>
                    <div class="basket-box" onclick="MainManager.basket(1)">
                        <button class="btn border" onclick="MainManager.basket(1)">В корзину</button>
                        <span class="data"></span>
                        <span class="basket-summary-count"><?= $summary_count ?></span> товаров — <span class="basket-summary-price"><?= $summary_price ?></span> руб.</span>
                    </div>
                </div>
            </div>
            <?php 
                $menu = CatalogCategory::find()->where(['show_in_app' => true, 'is_active' => true])->orderBy('sort')->all();
            ?>

            <ul class="menu nav" data-cat-menu>
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'all')?'active':'';?>" href="<?= Url::toRoute(['/menu/all']) ?>">Все букеты</a></li>

                <?php foreach ($menu as $item) { ?>
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'dish' && Yii::$app->request->get('alias') == $item->alias)?'active':'';?>" href="<?= !empty($item->alias) ? Url::toRoute(['/menu/dish', 'alias' => $item->alias]) : Url::toRoute(['/menu/dish', 'id' => $item->id]) ?>"><?= $item->title ?></a></li> <li class="sep"></li>
                <?php } ?>                
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'modificators')?'active':'';?>" href="<?= Url::toRoute(['/menu/modificators']) ?>">Камни</a></li>
            </ul>

            <button class="btn border cat-menu" onclick="MainManager.showMenu('data-cat-menu');"><span style="
background-color: green;
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 10px;
    color: white;
    webkit-border-radius: 10px;
    moz-border-radius: 10px;
    ms-border-radius: 10px;
    border-radius: 10px;">Выбрать категорию букета</span></button>
        </div>



    </div>

    <?= $content ?>

    <div class="footer">
        <div class="wrapper">


            <div class="row-col row">
                <div class="col col_4">
                    <a href="/" class="logo"></a>
                </div>
                <div class="col col_2">
                    <div class="money">
                        <a href="https://money.yandex.ru/" target="_blank" class="mon-icon-s_1"></a>
                        <a href="https://www.webmoney.ru/" target="_blank" class="mon-icon-s_2"></a>
                        <a href="http://www.visa.com.ru/" target="_blank" class="mon-icon-s_3"></a>
                        <a href="https://www.mastercard.ru/" target="_blank" class="mon-icon-s_4"></a>
                        <a href="https://qiwi.com/" target="_blank" class="mon-icon-s_5"></a>
                    </div>
                    <div class="social">


                        <a href="https://api.whatsapp.com/send?phone=79645057959" rel="nofollow" target="_blank" class="fa fa-whatsapp fa-2x"></a>
                        <a href="https://www.instagram.com/salvadorgardens/?hl=ru"  target="_blank" class="soc-icon-s_8"></a>
                    </div>
                </div>
                <div class="col col_4">
                    <a href="tel:+74959332849" class="phone">+7 495 <span>933-28-49</span></a>
                    <button class="btn black" onclick="MainManager.showModalById('modal-callback')">заказать звонок</button>
                </div>
            </div>

            <ul class="menu nav">
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'all')?'active':'';?>" href="<?= Url::toRoute(['/menu/all']) ?>">Все букеты</a></li>

                <?php foreach ($menu as $item) { ?>
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'dish' && Yii::$app->request->get('alias') == $item->alias)?'active':'';?>" href="<?= !empty($item->alias) ? Url::toRoute(['/menu/dish', 'alias' => $item->alias]) : Url::toRoute(['/menu/dish', 'id' => $item->id]) ?>"><?= $item->title ?></a></li> <li class="sep"></li>
                <?php } ?>
                <li><a class="<?= (Yii::$app->controller->id == 'menu' && Yii::$app->controller->action->id == 'modificators')?'active':'';?>" href="<?= Url::toRoute(['/menu/modificators']) ?>">Камни</a></li>
            </ul>
            <div class="copy row">
                <span>
                    © 2000–<?= date('Y') ?> <?= Setting::getValueByKey('tag_h3') ?>
                </span>   
            </div>
        </div>
    </div>
    <!-- Modal global-->
    <!-- <div class="modal fade" id="modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content"></div>
        </div>
    </div> -->

<?php if(Yii::$app->user->isGuest){ ?>
    <!-- Modal registration-->
    <div class="modal fade" id="modal-registration" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content">
                <?php $signup_model = new \frontend\models\SignupForm(); ?>
                <?= $this->render('@app/views/site/signup', ['signup_model' => $signup_model]); ?>
            </div>
        </div>
    </div>

    <!-- Modal authorization-->
    <div class="modal fade" id="modal-authorization" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content">
                <?php $login_model = new \common\models\LoginForm(); ?>
                <?= $this->render('@app/views/site/login', ['login_model' => $login_model]); ?>
            </div>
        </div>
    </div>

    <!-- Modal agreement-->
    <div class="modal fade" id="modal-agreement" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content">
                <form action="" class="">

                    <p>Соглашение</p>
                    <div class="agreement-content" data-scroll-agreement>
                        <p>Данное соглашение об обработке персональных данных разработано в соответствии с законодательством Российской Федерации.</p>
                        <p>Все пользователи, указывающие свои персональные данные на данном сайте подтверждают свое согласие на обработку персональных данных и их последующую передачу третьим лицам для оказания сервисных услуг, заказанных пользователем.</p>

                        <p>Под персональными данными Пользователей понимается нижеуказанная информация:</p>
                        <p>- общая информация (Ф.И.О. пользователя, год, число и месяц рождения, электронная почта, направленные на сайт фотографии);</p>
                        <p>- любая иная информация, касающаяся Пользователя и раскрытая им при заполнении анкет, а также любым другим способом на данном сайте.</p>

                        <p>Пользователи направляют свои персональные данные Администрации сайта в целях их передачи третьим лицам, заинтересованным в оказании сервисных услуг пользователю.</p>
                        <p>Пользователи, принимая настоящее Соглашение, выражают свою заинтересованность и полное согласие, что обработка их персональных данных может включать в себя следующие действия: сбор, систематизацию, накопление, хранение, уточнение (обновление, изменение), использование, распространение (в том числе передачу третьим лицам), обезличивание, блокирование, уничтожение.</p>

                        <p>Пользователь гарантирует:</p>
                        <p>- информация, им предоставленная, является полной, точной и достоверной;</p>
                        <p>- при предоставлении информации не нарушается действующее законодательство Российской Федерации, законные права и интересы третьих лиц;</p>
                        <p>- вся предоставленная на сайт информация заполнена Пользователем в отношении себя лично, все действия по регистрации на сайте совершены непосредственно Пользователем;</p>
                        <p>- не использовать чужие контактные данные, включая телефон, e-mail и т.п.;</p>
                        <p>- не создавать помехи в использовании Сайта другими Пользователями, в том числе посредством распространения компьютерных вирусов, неоднократного размещения дублирующей информации, одновременную отправку большого количества электронной почты либо запросов к Сайту и т.п.;</p>
                        <p>- не передавать информацию третьим лицам в отношении логина и пароля на данном сайте. Вся информация, полученная под регистрационными данными Пользователя, будет считаться полученной от него лично.</p>

                        <p>Пользователь проинформирован: </p>
                        <p>- что настоящее Соглашение может быть им отозвано посредством направления письменного заявления Администрации сайта;</p>
                        <p>- что срок хранения и обработки его персональных данных устанавливается по усмотрению Администрации сайта и может составлять до 10 лет с момента последнего размещения Пользователем информации. </p>
                        <p>Администрация сайта имеет право по своему усмотрению удалять информацию Пользователя из сайта в случаях возникновения у нее сомнений в соблюдении Пользователем условий настоящего Соглашения.</p>
                    </div>


                    <div class="_txt-center">
                        <a class="btn green" onclick="$('#modal-registration .checkbox').prop('checked', true); $('#modal-agreement').modal('hide'); $('#modal-registration').modal('show');" tabindex="6">принимаю</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php } ?>

    <!-- Modal callback-->
    <div class="modal fade" id="modal-callback" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content">

                <?php \yii\widgets\Pjax::begin(['id' => 'callback-pjax', 'enablePushState' => false]) ?>
                <?php $callback_form = new \frontend\models\forms\CallbackForm(); ?>
                <?= $this->render('@app/views/site/callback', ['callback_form' => $callback_form]); ?>
                <?php \yii\widgets\Pjax::end() ?>
                <?php
                    /*$this->registerJs(
                        '$("document").ready(function(){
                            $("#callback-pjax").on("pjax:end", function() {
                                $("#modal-callback").modal("hide");
                                MainManager.showModalById("modal-callback-success");
                            });
                        });'
                    );*/
                ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-callback-success" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-content">
                <p>Мы перезвоним вам в ближайшее время</p>
            </div>
        </div>
    </div>

    <!-- Modal basket -->
    <div class="modal fade" id="basket">
        <div class="modal-dialog basket-dialog small">
            <div class="modal-content">
                <button class="close-icon" data-dismiss="modal" aria-label="Close"></button>
                <p>Ваша корзина пуста</p>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
