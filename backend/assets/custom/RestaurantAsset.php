<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 22:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class RestaurantAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/backend/restaurant';




    public $css = [

          'restaurant.css'



    ];
    public $js = [
        'restaurant.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        //'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\ChosenAsset',








    ];


}