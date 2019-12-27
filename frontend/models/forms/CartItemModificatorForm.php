<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\CartItemModificator;

class CartItemModificatorForm extends Model
{
    public $cart_item_id;
    public $modificator_id;
    public $count;

    public function rules()
    {
        return [
            [['cart_item_id', 'modificator_id'], 'required'],
            [['cart_item_id', 'modificator_id', 'count'], 'integer'],
        ];
    }

    public function getSumm()
    {

    }

    public function add()
    {
		if ($this->validate()){
            $modificator = new CartItemModificator();
            $modificator->cart_item_id = $this->cart_item_id;
            $modificator->modificator_id = $this->modificator_id;
            $modificator->count = $this->count;

            if($modificator->save())
                return true;
        }
        return false;
    }

    public function isEqual()
    {

    }

    public function attributeLabels()
    {
        return [
            'cart_item_id' => 'Блюдо из корзины',
            'modificator_id' => 'Модификатор',
            'count' => 'Количество',
        ];
    }
}
