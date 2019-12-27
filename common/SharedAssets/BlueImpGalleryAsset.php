<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03.11.15
 * Time: 20:53
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class BlueImpGalleryAsset extends AssetBundle
{

    public $sourcePath = '@bower/blueimp-gallery';


    public $css = [
        'css/blueimp-gallery.css',

    ];
    public $js = [
        'js/blueimp-gallery.js',
    ];

    public $publishOptions = [
        'only' => [
            'css/*',
            'img/*',
            'js/*',


        ]
    ];

}