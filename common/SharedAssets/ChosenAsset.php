<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 24.10.15
 * Time: 18:03
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class ChosenAsset extends AssetBundle
{

    public $sourcePath = '@bower/chosen';


    public $css = [
        'chosen.min.css',

    ];
    public $js = [
        'chosen.jquery.min.js',
    ];


}