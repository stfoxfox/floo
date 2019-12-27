<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GalleryAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/gallery';

    public $css = [
        'gallery.css'
    ];

    public $js = [
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
