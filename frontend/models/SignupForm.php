<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\components\MyExtensions\MyHelper;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    //public $email;
    //public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required','message'=>"Укажите номер вашего телефона в верном формате"],
           // ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот номер телефона уже используется'],
            ['username', 'string', 'min' => 2, 'max' => 255],
           // ['username', 'validate_new_phone_number', 'message' => 'Этот номер телефона уже зарегистрирован'],

            /*['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],*/
        ];
    }

    public function validate_new_phone_number($attribute, $params){
        if (!$this->hasErrors()) {
            $phone= MyHelper::preparePhone($this->username);
            $user = User::find()->where(['username' => $phone])->one();
            if ($user) {
                $this->addError($attribute, 'Этот номер телефона уже зарегистрирован');
            }
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $phone=$this->username;

        $prepared_phone= MyHelper::preparePhone($phone);
        
        $password =$this->randomString(4);

        if ($user = User::find()->where(['username' => $prepared_phone])->one()) {
            $user->setPassword($password);

            if ($user->save()) {
                $r = MyHelper::sendSms("Ваш пароль: " . $password,$phone);
                return $user;
            }
        } else {

            $user = new User();
            $user->username = $prepared_phone;
            // $password =$this->randomString(4);
            $user->status =User::STATUS_NOT_CONFIRMED;
            $user->setPassword($password);
            $user->generateAuthKey();

            if ($user->save()) {
                MyHelper::sendSms("Ваш пароль: " . $password,$phone);
                return $user;

            }
        }

        $user = new User();
        $user->username =  $phone= MyHelper::preparePhone($this->username);;
        //$user->email = $this->email;

        // $password = $this->randomString();
        MyHelper::sendSms("Ваш пароль: " . $password,$user->username);

        $user->setPassword($password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

    protected function randomString($length = 4) {
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
