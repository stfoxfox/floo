<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AboutAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/app';

    public $css = [
    	'css/about.css'
    ];

    public $js = [

    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
