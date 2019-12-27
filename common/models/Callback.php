<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12/01/2017
 * Time: 23:34
 */

namespace common\models;


use common\models\BaseModels\CallbackBase;

class Callback extends CallbackBase
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}