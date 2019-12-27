<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19/12/2016
 * Time: 23:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class PromoIndexAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/backend/promo';




    public $css = [

        'promo_index.css'



    ];
    public $js = [
        'promo_index.js'



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