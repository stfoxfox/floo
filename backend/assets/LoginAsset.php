<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12.10.15
 * Time: 11:15
 */

namespace backend\assets;


use yii\web\AssetBundle;

class LoginAsset extends AssetBundle
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

    ];
    public $depends = [
        'yii\web\JqueryAsset'

    ];


}