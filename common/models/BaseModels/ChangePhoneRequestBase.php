<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "change_phone_request".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $new_phone
 * @property string $password_hash
 * @property string $created_at
 * @property string $updated_at
 */
class ChangePhoneRequestBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'change_phone_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['new_phone', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['new_phone', 'password_hash'], 'string', 'max' => 255],
                  ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'new_phone' => 'New Phone',
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
