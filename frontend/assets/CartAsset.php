<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CartAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/cart';

    public $css = [
    ];

    public $js = [
    	'cart.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
        'frontend\assets\CabinetAsset', // !important
    ];
}
