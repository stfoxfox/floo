<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 12/01/2017
 * Time: 23:34
 */

namespace common\models;


use common\models\BaseModels\CartBase;

class Cart extends CartBase
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCartItems()
    {
        return $this->hasMany(CartItem::className(), ['cart_id' => 'id']);
    }


    public function getSum(){

        $order_summ = 0;
        foreach ($this->cartItems as $cart_item) {
            $order_summ += $cart_item->getSum();
        };

        return $order_summ;
    }

}