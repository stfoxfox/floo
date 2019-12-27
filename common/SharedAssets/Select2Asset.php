<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class Select2Asset extends  AssetBundle
{

    public $sourcePath = '@bower/select2';


    public $css = [
        'dist/css/select2.min.css',

    ];
    public $js = [
        'dist/js/select2.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/*',
            'dist/css/*',
            'dist/js/*',
            'dist/js/i18n/*',

        ]
    ];

}