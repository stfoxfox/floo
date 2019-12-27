<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class OrderAsset extends AssetBundle
{

    public $sourcePath = '@frontend/assets/custom/order';

    public $css = [
    ];

    public $js = [
    	'order.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
        'frontend\assets\CabinetAsset', // !important

        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\MomentAsset',
        'common\SharedAssets\XEditableAsset',
    ];
}
