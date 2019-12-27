<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 02/12/2016
 * Time: 23:22
 */

namespace common\models;


use common\models\BaseModels\ApiTokenBase;
use Ramsey\Uuid\Uuid;

class ApiToken extends ApiTokenBase
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['api_token_uuid' => 'token']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('user_auth', ['api_token_uuid' => 'token']);
    }


    public static function generateToken(){

        $randStr = Uuid::uuid1()->toString();


        $count= ApiToken::find()->where(['token'=>$randStr])->count();

        if($count==0)
            return $randStr;
        else
            return
                self::generateToken();


    }


}