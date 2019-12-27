<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 22:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class CatalogAddCategoryAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/account/catalog';




    public $css = [

          'catalog-add.css'



    ];
    public $js = [
        'catalog-add.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\SweetAllertAsset',
    ];


}