<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\MyExtensions\MyHelper;
use common\models\ChangePhoneRequest;

class UserNameForm extends Model
{
    public $username;
    public $new_username;

    public function rules()
    {
        return [
            [['username', 'new_username'], 'required'],
            //['new_username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            [['username', 'new_username'], 'string'],
            [['new_username'], 'validate_new_phone_number', 'message' => 'Этот номер телефона уже зарегистрирован'],
        ];
    }

    public function validate_new_phone_number($attribute, $params){
        if (!$this->hasErrors()) {
            $phone= MyHelper::preparePhone($this->new_username);
            $user = User::find()->where(['username' => $phone])->one();
            if ($user) {
                $this->addError($attribute, 'Этот номер телефона уже зарегистрирован');
            }
        }
    }

    public function change()
    {
        if(!Yii::$app->user->isGuest){

            $phone= MyHelper::preparePhone($this->new_username);
            $user = User::find()->where(['username' => $phone])->one();
            if ($user) {
                return false;
            }else{
                $item = new ChangePhoneRequest();
                $item->new_phone=$phone;
                $item->user_id=\Yii::$app->user->id;
                $password =$this->randomString(4);

                MyHelper::sendSms("Ваш пароль: " . $password,$phone);
                $item->password_hash=\Yii::$app->security->generatePasswordHash($password);
                if ($item->save()){
                    return $item->id;
                }
            }
        }
        return false;
    }

    public function my(){
        $this->username = Yii::$app->user->identity->username;
        return $this;
    }

    protected function randomString($length = 6) {
        $str = "";
        $characters = array_merge(  range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}
