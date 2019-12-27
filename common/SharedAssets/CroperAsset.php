<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03.11.15
 * Time: 18:16
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class CroperAsset extends AssetBundle
{

    public $sourcePath = '@bower/cropper';


    public $css = [
        'dist/cropper.css',

    ];
    public $js = [
        'dist/cropper.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/*',
            'src/*',


        ]
    ];



}