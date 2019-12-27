<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:44
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class ModificatorsAsset extends AssetBundle
{

    public $sourcePath = '@common/assets/custom/backend/modificator';




    public $css = [

        'modificator.css'



    ];
    public $js = [
        'modificator.js'



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