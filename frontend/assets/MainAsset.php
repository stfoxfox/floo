<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MainAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/main';

    public $css = [
        'main.css',
    ];

    public $js = [
        'main.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
