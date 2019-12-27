<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/07/2017
 * Time: 15:36
 */

namespace common\SharedAssets;


use yii\web\AssetBundle;

class EditableAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/custom/common/editable';



    public $js = [
        'editable.js'



    ];
    public $depends = [
        'backend\assets\MainAsset',
        'common\SharedAssets\XEditableAsset',

    ];


}