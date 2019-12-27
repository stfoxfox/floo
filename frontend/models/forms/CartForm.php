<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Cart;

class CartForm extends Model
{
    public $order_summ;
    public $user_id;

    public function rules()
    {
        return [
            ['order_summ', 'required'],
            [['order_summ', 'user_id'], 'integer'],
        ];
    }

    public function add()
    {
        $cart = new Cart();
        if(!Yii::$app->user->isGuest) 
            $cart->user_id=Yii::$app->user->id;
            $cart->order_summ=0;

        if ($cart->save()){
            return $cart->id;
        }
        return false;
    }

    public function repeatOrder()
    {

    }

    public function addCardItem($cart_id, $catalogItem_id, $catalogItem_count, $catalogItem_size, $modificators)
    {

        $cartItem = new CartItemForm();
        $cartItem->cart_id = $cart_id;
        $cartItem->catalog_item_id = $catalogItem_id;
        $cartItem->catalog_item_pizza_options = $this->get_pizza_option_index($catalogItem_size);
        $cartItem->count = $catalogItem_count;
        $cartItem->modificators = $modificators;

        if ($cartItem->add()){
            return true;
        }
        return false;
    }

    public function dellCartItem()
    {
        
    }

    public function attributeLabels()
    {
        return [
            'order_summ' => 'Общая сумма заказа',
            'user_id' => 'Пользователь',
        ];
    }

    protected function get_pizza_option_index($catalog_item_pizza_options)
    {
        $index = 0;

        if (is_int($catalog_item_pizza_options)){
            return $catalog_item_pizza_options;
        }

        switch ($catalog_item_pizza_options) {
            case 'st_st':
                $index = CartItemForm::PIZZA_OPTION_ST_ST;
                break;
            
            case 'big_st':
                $index = CartItemForm::PIZZA_OPTION_BIG_ST;
                break;
            
            case 'st_big':
                $index = CartItemForm::PIZZA_OPTION_ST_BIG;
                break;
            
            case 'big_big':
                $index = CartItemForm::PIZZA_OPTION_BIG_BIG;
                break;
            
            default:
                $index = CartItemForm::PIZZA_OPTION_NONE;
                break;
        }
        return $index;
    }
}
