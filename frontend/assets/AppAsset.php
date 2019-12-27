<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    
    public $sourcePath = '@frontend/assets/app';

    public $css = [
        'css/normalize.css',
        'font/include-font.css',
        'icon/include-icon.css',
        'css/base.css',
        'css/ui.css',

        'lib/jquery/owl.carousel.css',
        'lib/jquery/jquery.mCustomScrollbar.css',

        'css/parallax.css',
        'css/media.css',

        'css/fix.css',

        'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ];

    public $js = [
        '//api-maps.yandex.ru/2.0-stable/?load=package.full&mode=release&lang=ru-RU',
       // 'lib/jquery/jquery.min.js',
        'lib/jquery/parallax.min.js',
        'lib/jquery.mask.js',
        'lib/bootstrap/bootstrap.min.js',
        'lib/bootstrap/bootstrap-select.min.js',
        'lib/jquery/jquery.mCustomScrollbar.js',
        'lib/jquery/owl.carousel.min.js',
        'js/manager.js',
        'js/init.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',

        'common\SharedAssets\SweetAllertAsset',
    ];
}
