<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 16/01/2017
 * Time: 23:32
 */

namespace backend\models\forms;


use common\models\Organisation;
use yii\base\Model;

class OrganisationEditForm extends Model
{


    public $title;
    public $sber_login;
    public $sber_pass;
    public $platron_login;
    public $platron_pass;

    public function rules()
    {
        return [
            // username and password are both required
            [['title'], 'required'],
            [['sber_login','sber_pass','platron_login','platron_pass'], 'safe'],
            // rememberMe must be a boolean value

        ];

    }


    /**
     * @param Organisation $item
     */
    public function loadFormModel($item){

        $this->title=$item->title;
        $this->sber_login=$item->sber_user;
        $this->sber_pass=$item->sber_pass;
        $this->platron_login=$item->platron_user;
        $this->platron_pass=$item->platron_pass;


    }


    public function saveItem($item){

        if ($this->validate()){


            $item->title=$this->title;
            $item->sber_user=$this->sber_login;
            $item->sber_pass=$this->sber_pass;
            $item->platron_user=$this->platron_login;
            $item->platron_pass=$this->platron_pass;
            if ($item->save()){
                return $item;
            }

        }
        return false;

    }
}