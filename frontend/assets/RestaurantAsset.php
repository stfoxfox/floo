<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class RestaurantAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/restaurant';

    public $css = [
        'restaurant.css',
    ];

    public $js = [
        'restaurant.js'
    ];

    public $depends = [
       // 'frontend\assets\AppAsset',
    ];
}
