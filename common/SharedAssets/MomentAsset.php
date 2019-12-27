<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class MomentAsset extends AssetBundle
{

    public $sourcePath = '@bower/moment';


    public $css = [
    //    'dist/bootstrap3-editable/css/bootstrap-editable.css',

    ];
    public $js = [
        'min/moment.min.js',
    ];

    public $publishOptions = [

    ];

}