<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;

use common\models\Callback;
use yii\base\Model;

class CallbackForm extends Model
{


    public $active;


    public function rules()
    {
        return [
        
            ['active', 'boolean'],

        ];
    }



    public function closeCallback($id){

        if ($this->validate()){

            $callback = Callback::findOne($id);

            $callback->active=false;

            if ($callback->save()){

                return $callback;
            }

        }

        return false;
    }

}