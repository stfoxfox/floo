<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 0:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class EditRestaurantAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/backend/edit_restaurant';


    public $css = [

        'edit_restaurant.css'



    ];
    public $js = [
        'edit_restaurant.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\MomentAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];


}