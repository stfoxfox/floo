<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 12:04
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class BSDateTimePickerAsset extends AssetBundle
{

    public $sourcePath = '@bower/smalot-bootstrap-datetimepicker';


    public $css = [
        'css/bootstrap-datetimepicker.css',

    ];
    public $js = [
        'js/bootstrap-datetimepicker.js',
    ];

    public $publishOptions = [
        'only' => [
            'js/*',
            'js/locales/*',
            'css/*',

        ]
    ];

}