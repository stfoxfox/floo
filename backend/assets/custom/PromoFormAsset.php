<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 07.11.15
 * Time: 22:48
 */

namespace backend\assets\custom;


use yii\web\AssetBundle;

class PromoFormAsset extends AssetBundle
{


    public $sourcePath = '@common/assets/custom/backend/promo_form';




    public $css = [

          'promo_form.css'



    ];
    public $js = [
        'promo_form.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\Select2Asset',
        'common\SharedAssets\SweetAllertAsset',
        'common\SharedAssets\JqueryUIAsset',
        'common\SharedAssets\XEditableAsset',
        'common\SharedAssets\CroperAsset'







    ];


}