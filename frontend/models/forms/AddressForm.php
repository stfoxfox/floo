<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Address;

class AddressForm extends Model
{
    public $address;
    public $entrance;
    public $floor;
    public $flat;

    public function rules()
    {
        return [
            ['address', 'required'], //'message' => 'Необходимо указать точный и корректный адрес доставки.'],
            [['address', 'entrance', 'floor', 'flat'], 'string'],
        ];
    }

    public function add(){
        $address = new Address();
        if($this->validate()){
            $address->user_id = \Yii::$app->user->id;
            $address->address = $this->address;
            $address->entrance = $this->entrance;
            $address->floor = $this->floor;
            $address->flat = $this->flat;

            $address->full_address = $this->address;
            $address->lat = 123.123;
            $address->lng = 65.123;
            $address->location = "SRID=4326;POINT(-71.060316 48.432044)";

            if ($address->save()){
                return $address;
            }
        }
    }
}
