<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 30/06/2017
 * Time: 22:24
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class ModificatorItemGalleryAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/custom/backend/catalog_item_gallery';

    public $css = [
        //   'blog.css'
    ];

    public $js = [
        'catalog_item_gallery.js'
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