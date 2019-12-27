<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Callback;

class CallbackForm extends Model
{
    public $name;
    public $phone;
    public $verifyCode;

    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['name', 'phone'], 'string'],
            //['verifyCode', 'captcha'],
        ];
    }

    public function saveCallback()
    {
        if ($this->validate()){
            $callback = new Callback();
            $callback->name=$this->name;
            $callback->phone=$this->phone;
            if(!Yii::$app->user->isGuest) $callback->user_id=Yii::$app->user->id;

            if ($callback->save()){
                return true;
            }
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Представьтесь',
            'phone' => 'Телефон',
            'verifyCode' => 'Введите код с картинки',
        ];
    }
}
