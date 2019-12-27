<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class SweetAllertAsset extends  AssetBundle
{

    public $sourcePath = '@bower/sweetalert';


    public $css = [
        'dist/sweetalert.css',

    ];
    public $js = [
        'dist/sweetalert.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/*',

        ]
    ];

}