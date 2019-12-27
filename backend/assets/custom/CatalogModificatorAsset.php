<?php

namespace backend\assets\custom;

use yii\web\AssetBundle;

class CatalogModificatorAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/custom/backend/catalog-modificator';

    public $js = [
        'catalog-modificator.js'
    ];

    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\ChosenAsset',
    ];
}