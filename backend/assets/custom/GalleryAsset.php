<?php

namespace backend\assets\custom;


use yii\web\AssetBundle;

class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/custom/backend/gallery';

    public $css = [
        //   'blog.css'
    ];

    public $js = [
        'gallery.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\CroperAsset',
        'common\SharedAssets\JqueryFormAsset',
        'common\SharedAssets\LightboxAsset',
    ];
}