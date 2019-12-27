<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 13.10.15
 * Time: 11:39
 */

namespace backend\assets;


use yii\web\AssetBundle;

class MainAsset extends  AssetBundle
{

    public $sourcePath = '@common/assets/template';


    public $css = [
        'css/bootstrap.min.css',
        'font-awesome/css/font-awesome.css',
        'css/animate.css',
        'css/style.css',

    ];
    public $js = [

        'js/bootstrap.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'

    ];

}