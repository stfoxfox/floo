<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property string $user_token
 * @property string $api_token_uuid
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class UserAuthBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_token', 'api_token_uuid'], 'string'],
            [['api_token_uuid', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_token'], 'unique'],
            [['user_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_token' => 'User Token',
            'api_token_uuid' => 'Api Token Uuid',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
