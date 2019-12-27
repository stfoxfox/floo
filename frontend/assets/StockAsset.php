<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class StockAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/stock';

    public $css = [

    ];

    public $js = [

    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
