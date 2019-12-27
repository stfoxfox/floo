<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

class UserPersonalForm extends Model
{
    public $first_name;
    public $last_name;
    public $birthday;
    public $email;

    public function rules()
    {
        return [
            ['email', 'required'],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            [['first_name', 'last_name', 'birthday', 'email'], 'string'],
        ];
    }

    public function change()
    {
        $user = Yii::$app->user->identity;
        if(!Yii::$app->user->isGuest) {
            $user->name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->birthday = $this->birthday;
            $user->email = $this->email;
            if ($user->save()){
                return true;
            }
        }
        return false;
    }

    public function me(){
        $this->first_name = Yii::$app->user->identity->name;
        $this->last_name = Yii::$app->user->identity->last_name;
        $this->birthday = Yii::$app->user->identity->birthday == '' ? '' : date('Y-m-d', strtotime(Yii::$app->user->identity->birthday));
        $this->email = Yii::$app->user->identity->email;
        return $this;
    }
}
