<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SoupAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/soup';

    public $css = [
    	'soup.css'
    ];

    public $js = [

    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
