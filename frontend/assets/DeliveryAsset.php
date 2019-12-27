<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DeliveryAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/delivery';

    public $css = [
        'delivery.css'
    ];

    public $js = [
        'delivery.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
