<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/11/2017
 * Time: 11:00
 */

namespace frontend\models\forms;


use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyHelper;
use common\models\BaseModels\RestaurantBase;
use common\models\BaseModels\ReviewBase;
use common\models\Vacancy;
use yii\base\Model;

class ReviewForm extends Model
{



    public $name;
    public $phone;
    public $review_text;
    public $file_name;
    public $restaurant_id;



    public function rules()
    {
        return [
            [['name', 'phone', 'review_text', 'restaurant_id'], 'required'],
            [['name'], 'string', 'max' => 80],
        ];
    }



    public function submit(){



        $review = new ReviewBase();
        $review->name=$this->name;
        $review->phone=$this->phone;
        $review->review_text=$this->review_text;
        $review->is_active= false;
        $review->restaurant_id = $this->restaurant_id;

        if ($review->save()){



            $emails = ['popov.anatoliy@gmail.com'];


            $restaurant = RestaurantBase::findOne($this->restaurant_id)->address;
            foreach ($emails as $email){
                $message = "
                  Имя: $this->name
                  Телефон: $this->phone
                  Ресторан: $restaurant
                  Отзыв: $this->review_text,                  
                  ";

                MyHelper::sendMessage($message,"Новый отзыв",$email);



            }
        }









        return true;
    }

}