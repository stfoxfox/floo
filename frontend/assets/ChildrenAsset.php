<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ChildrenAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/children';

    public $css = [
        'children.css',
    ];

    public $js = [
        'children.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
