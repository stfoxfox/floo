<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class SignupAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/signup';

    public $css = [
    	'signup.css'
    ];

    public $js = [
        'signup.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
