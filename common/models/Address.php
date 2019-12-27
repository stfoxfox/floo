<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 18/12/2016
 * Time: 23:52
 */

namespace common\models;


use common\models\BaseModels\AddressBase;

class Address extends AddressBase
{


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return array
     */

    public  function getJson(){

        $return_obj = array(
            'id'=>$this->id,
            'address'=>$this->address,
            'lng'=>$this->lng,
            'lat'=>$this->lat,
            'entrance'=>$this->entrance,
            'floor'=>$this->floor,
            'flat'=>$this->flat,
        );

        if ($this->full_address){

            $return_obj['full_address']=$this->full_address;
        }

        return $return_obj;

    }
}