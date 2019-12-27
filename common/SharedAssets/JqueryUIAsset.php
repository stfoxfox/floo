<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24.10.15
 * Time: 0:47
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class JqueryUIAsset extends AssetBundle
{

    public $sourcePath = '@bower/jquery-ui';


    public $css = [
        'themes/smoothness/jquery-ui.min.css',

    ];
    public $js = [
        'jquery-ui.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'themes/smoothness/jquery-ui.min.css',
            'jquery-ui.min.js',


        ]
    ];




}