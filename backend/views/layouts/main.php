<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\MainAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\MyAllert;
use \common\widgets\MenuWithIcons;
use yii\helpers\Url;

$asset = MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="fixed-navigation">


<?php $this->beginBody() ?>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>

                             </span>
                        <a  href="<?=Url::toRoute('user/settings')?>">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=Yii::$app->user->identity->username?></strong>
                             </span> <span class="text-muted text-xs block">Настройки <b class="caret"></b></span> </span> </a>

                    </div>
                    <div class="logo-element">
                       PR
                    </div>
                </li>


                <?php

                echo MenuWithIcons::widget([
                    'items' => [
                        // Important: you need to specify url as 'controller/action',
                        // not just as 'controller' even if default action is used.
                        ['label'=>'Панель управления' ,'url'=>['site/index'],'icon'=>'fa-th-large'],
                        ['label'=>'Меню' ,'url'=>['catalog/view'],'icon'=>'fa-cutlery'],
                        ['label'=>'Модификаторы' ,'url'=>['modificator/index'],'icon'=>'fa-plus-circle'],
                        ['label'=>'Рестораны' ,'url'=>['restaurant/view'],'icon'=>'fa-home'],
                        ['label'=>'Акции' ,'url'=>['promo/index'],'icon'=>'fa-gift'],
                        ['label'=>'Заказы' ,'url'=>['order/index'],'icon'=>'fa-shopping-cart'],
                        ['label'=>'Заявки на звонок' ,'url'=>['callback/index'],'icon'=>'fa-phone'],
                        ['label'=>'Вакансии' ,'url'=>['vacancy/index'],'icon'=>'fa-phone'],
                        ['label'=>'Отзывы' ,'url'=>['review/index'],'icon'=>'fa-phone'],
                        ['label'=>'Отклики на вакансии' ,'url'=>['vacancy-response/index'],'icon'=>'fa-phone'],
                        ['label'=>'Администраторы' ,'url'=>['backend-users/list'],'icon'=>'fa-th-large',],
                        ['label'=>'Настройки сайта' ,'url'=>['site-settings/index'],'icon'=>'fa-cog',],
                        ['label'=>'Настройки' ,'url'=>['setting/index'],'icon'=>'fa-cog',],
                        ['label'=>'Галерея' ,'url'=>['gallery/index'],'icon'=>'fa-cog',],


                        // 'Products' menu item will be selected as long as the route is 'product/index'
                    ],
                    'options'=>[
                        'class'=>'nav metismenu',
                        'id'=>'side-menu',

                    ]

                ]);

                ?>

            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top  <?php if(!$this->context->show_header) { ?>white-bg<?php } ?>" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-success " href="#"><i class="fa fa-bars"></i> </a>

                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message"></span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <?php $callbacks = \common\models\Callback::find()->where(['active' => true])->orderBy(['created_at'=> SORT_DESC])->all(); ?>
                            <i class="fa fa-phone"></i>  <span class="label label-success"><?= count($callbacks); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <?php foreach ($callbacks as $index => $callback) { ?>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="callto:<?= $callback->phone ?>" class="pull-left">
                                        <?= $callback->phone ?>
                                    </a>
                                    <div>
                                        <a href="<?=Url::toRoute(['/callback/close', 'id' => $callback->id])?>" class="pull-right label label-info">x</a>
                                        <strong><?= $callback->name ?></strong> <br>
                                        <small class="text-muted"><?= $callback->created_at ?></small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <?php 
                            $show_count = 5;
                            $show_more = count($callbacks) - $show_count;
                            if($index >= $show_count - 1) { ?>
                            <li>
                                <div class="text-center link-block">
                                    <a href="<?=Url::toRoute('/callback/index')?>">
                                        <i class="fa fa-phone"></i> <strong>Посмотреть все заявки <?= ($show_more >0)?('<span class="label label-info">+'.(count($callbacks)-$show_count).'</span>'):'';?></strong>
                                    </a>
                                </div>
                            </li>
                            <?php    break;
                            }?>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">

                                    </a>
                                    <div>
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">

                                    </a>
                                    <div>
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">

                                    </a>
                                    <div>
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a data-method = 'post' href="<?=Url::toRoute('site/logout')?>" >
                            <i class="fa fa-sign-out"></i> Выйти
                        </a>
                    </li>

                </ul>

            </nav>
        </div>

        <?php if($this->context->show_header) { ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2><?=$this->context->pageHeader?></h2>

                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>

                </div>
            </div>
        <?php } ?>
        <div class="wrapper wrapper-content">

            <?= MyAllert::widget() ?>
            <?=$content?>

        </div>
        <div class="footer">
            <div class="pull-right">

            </div>
            <div>
                <strong>Copyright</strong> Pronto24.ru &copy; <?=date('Y')?>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
