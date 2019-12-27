<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property string $key
 * @property \common\widgets\SettingEnum $type
 * @property string $value
 */
class SettingBase extends \common\components\MyExtensions\MyActiveRecord
{
    public $file_name;
    public $value_image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'type', 'value', 'title'], 'required'],
            [['key', 'title', 'file_name', ], 'string'],
            [['type', 'value', 'value_image'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'key' => 'Key',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }
}
