<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21.10.15
 * Time: 13:47
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class GoogleMapsAsset extends AssetBundle
{

    public $js = [
        '//maps.googleapis.com/maps/api/js?key=AIzaSyBF6QQ2VFkuLzvUnnQPJCYJi_fiZBP8lcQ&libraries=places&callback=initMap',
    ];




}