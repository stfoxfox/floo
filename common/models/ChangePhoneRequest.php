<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 03/01/2017
 * Time: 00:38
 */

namespace common\models;


use common\models\BaseModels\ChangePhoneRequestBase;
use Yii;

class ChangePhoneRequest extends  ChangePhoneRequestBase
{




    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}