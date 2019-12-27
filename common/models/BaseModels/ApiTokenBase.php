<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "api_token".
 *
 * @property string $token
 * @property integer $device_type
 * @property string $device_token
 * @property string $lang
 * @property string $created_at
 * @property string $updated_at
 */
class ApiTokenBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['token', 'device_token'], 'string'],
            [['device_type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['lang'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'device_type' => 'Device Type',
            'device_token' => 'Device Token',
            'lang' => 'Lang',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
