<?php

namespace backend\assets\custom;

use yii\web\AssetBundle;

class RestaurantZoneAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/backend/restaurant-zone';


    public $css = [
          'restaurant-zone.css'
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?load=package.map&lang=ru-RU',
        'restaurant-zone.js',
        
    ];
    public $depends = [
        'backend\assets\MainAsset',
        //'common\SharedAssets\Select2Asset',
        //'common\SharedAssets\SweetAllertAsset',
        //'common\SharedAssets\JqueryUIAsset',
        //'common\SharedAssets\XEditableAsset',
        //'common\SharedAssets\ChosenAsset',
    ];


}