<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06.11.15
 * Time: 11:41
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class XEditableAsset extends AssetBundle
{

    public $sourcePath = '@bower/x-editable';


    public $css = [
        'dist/bootstrap3-editable/css/bootstrap-editable.css',

    ];
    public $js = [
        'dist/bootstrap3-editable/js/bootstrap-editable.js',
    ];

    public $publishOptions = [
        'only' => [
            'dist/bootstrap3-editable/js/*',
            'dist/bootstrap3-editable/css/*',
            'dist/bootstrap3-editable/img/*',
        ]
    ];

}