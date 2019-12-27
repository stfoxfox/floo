<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property integer $balance
 * @property string $ext_uuid
 * @property string $last_name
 * @property string $birthday
 */
class UserBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['status', 'balance'], 'integer'],
            [['created_at', 'updated_at', 'birthday'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'name', 'last_name', 'ext_uuid'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'last_name' => 'Last Name',
            'birthday' => 'Birthday',
            'balance' => 'Balance',
            'ext_uuid' => 'Ext Uuid',
        ];
    }
}
