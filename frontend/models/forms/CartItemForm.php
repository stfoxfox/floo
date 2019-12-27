<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\CartItem;

class CartItemForm extends Model
{
    const PIZZA_OPTION_NONE = 0;
    const PIZZA_OPTION_ST_ST = 1;
    const PIZZA_OPTION_BIG_ST = 2;
    const PIZZA_OPTION_ST_BIG = 3;
    const PIZZA_OPTION_BIG_BIG = 4;

    public $cart_id;
    public $catalog_item_id;
    public $catalog_item_pizza_options;
    public $count;
    public $modificators;

    public function rules()
    {
        return [
            [['cart_id', 'catalog_item_id'], 'required'],
            [['cart_id', 'catalog_item_id', 'catalog_item_pizza_options', 'count'], 'integer'],
        ];
    }
    public function add(){
        if ($this->validate()){
            if($exist_item_id = $this->isEqual()){
                $cartItem = CartItem::findOne($exist_item_id);
                $cartItem->count += $this->count;
                if($cartItem->save())
                    return true;
            }else{
                $cartItem = new CartItem();
                $cartItem->cart_id = $this->cart_id;
                $cartItem->catalog_item_id = $this->catalog_item_id;
                $cartItem->catalog_item_pizza_options = $this->catalog_item_pizza_options;
                $cartItem->count = $this->count;

                if($cartItem->save()){
                    $this->addIngredient($cartItem->id);
                    return true;
                }
            }
        }
        return false;
    }

    public function getSumm()
    {

    }

    public function isEqual()
    {
        $id = false;
        $cart_items = CartItem::find()->where([
            'cart_id' => $this->cart_id,
            'catalog_item_id' => $this->catalog_item_id,
            'catalog_item_pizza_options' => $this->catalog_item_pizza_options,
        ])->all();

        foreach ($cart_items as $cart_item) {
            if($cart_item){
                $all_modificators_equal = true;
                if(count($cart_item->cartItemModificators) == count($this->modificators)){//по количеству модификаторов
                    foreach ($cart_item->cartItemModificators as $cart_item_modificator) {
                        if( array_key_exists($cart_item_modificator->modificator_id,$this->modificators) ){//сравнение каждого модификатора на совпадение из нового заказа
                            if( $cart_item_modificator->count == $this->modificators[$cart_item_modificator->modificator_id]){//проверка количества модификатора
                                $all_modificators_equal = true;
                            }else{
                                $all_modificators_equal = false;
                            }
                        }else{
                            $all_modificators_equal = false;
                        }
                        
                    }
                }else{
                    $all_modificators_equal = false;
                }

                if($all_modificators_equal){
                    return $cart_item->id;
                }
            }
        }

        return false;
    }

    public function addIngredient($cart_item_id)
    {
        if(is_array($this->modificators) && !empty($this->modificators))
            foreach ($this->modificators as $id => $count) {
                $modificator = new CartItemModificatorForm();
                $modificator->cart_item_id = $cart_item_id;
                $modificator->modificator_id = $id;
                $modificator->count = $count;
                $modificator->add();
            }
        return true;
    }

    public function dellIngredient()
    {
        
    }

    public function attributeLabels()
    {
        return [
            'cart_id' => 'Корзина',
            'catalog_item_id' => 'Блюдо',
            'catalog_item_pizza_options' => 'Тип пиццы',
            'count' => 'Количество',
        ];
    }
}
