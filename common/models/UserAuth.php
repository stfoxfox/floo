<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 02/12/2016
 * Time: 23:24
 */

namespace common\models;


use common\models\BaseModels\UserAuthBase;

class UserAuth extends UserAuthBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApiTokenUu()
    {
        return $this->hasOne(ApiToken::className(), ['token' => 'api_token_uuid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return self|null
     */
    public static function findByApiTokenAndUserId($api_token_id,$user_id){

        return self::find()->where(['api_token_uuid'=>$api_token_id,'user_id'=>$user_id])->one();

    }


}