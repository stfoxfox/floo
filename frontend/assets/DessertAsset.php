<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class DessertAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/dessert';

    public $css = [
    	'dessert.css'
    ];

    public $js = [

    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
