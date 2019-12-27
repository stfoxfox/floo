<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CabinetAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/cabinet';

    public $css = [
    	'cabinet.css',
    	'https://cdn.jsdelivr.net/jquery.suggestions/16.8/css/suggestions.css',
    ];

    public $js = [
        'cabinet.js',
    	'https://cdn.jsdelivr.net/jquery.suggestions/16.8/js/jquery.suggestions.min.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
