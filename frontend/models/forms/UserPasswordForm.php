<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

class UserPasswordForm extends Model
{
    public $password;
    public $new_password;

    public function rules()
    {
        return [
            [['password', 'new_password'], 'required'],
            [['password', 'new_password'],'string', 'min' => 4],
            ['password', 'validatePassword', 'message' => 'Неправильный логин или пароль'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function change()
    {
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $user->setPassword($this->new_password);

            if ($user->save()){
                return true;
            }
        }
        return false;
    }
}
