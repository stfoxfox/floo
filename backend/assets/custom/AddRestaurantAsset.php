<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class AddRestaurantAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/backend/add_restaurant';


    public $css = [

        'add_restaurant.css'



    ];
    public $js = [
        'add_restaurant.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',

    ];


}