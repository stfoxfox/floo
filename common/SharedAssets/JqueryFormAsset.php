<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24.10.15
 * Time: 0:47
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class JqueryFormAsset extends AssetBundle
{

    public $sourcePath = '@bower/jquery-form';


    public $css = [


    ];
    public $js = [
        'jquery.form.js',
    ];

    public $publishOptions = [
        'only' => [

            'jquery.form.js',


        ]
    ];




}