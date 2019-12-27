<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03.11.15
 * Time: 20:53
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class LightboxAsset extends AssetBundle
{

    public $sourcePath = '@bower/lightbox2';


    public $css = [
        'dist/css/lightbox.css',

    ];
    public $js = [
        'dist/js/lightbox.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/js/*',
            'dist/css/*',
            'dist/images/*',
        ]
    ];

}