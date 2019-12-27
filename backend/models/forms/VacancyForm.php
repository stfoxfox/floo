<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 16/12/2016
 * Time: 20:52
 */

namespace backend\models\forms;



use common\components\MyExtensions\MyFileSystem;
use common\models\CatalogItem;
use common\models\Restaurant;
use common\models\Vacancy;
use yii\base\Model;
use common\models\Promo;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class VacancyForm extends Model
{


    public $title;
    public $description;
    public $is_active;

    public $restaurants_array= array();
    public $items_array =array();




    public function rules()
    {
        return [

            ['title', 'required'],

            ['title', 'filter', 'filter' => 'trim'],
            ['restaurants_array', 'safe'],
            ['description', 'safe'],

            ['is_active','boolean'],


        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название вакансии',
            'description' => 'Описание вакансии',
            'active' => 'Активная',
           ];
    }


    /**
     * @param Vacancy $item
     */
    public function loadFormItem($item){

        $this->title=$item->title;
        $this->description=$item->description;
        $this->restaurants_array= ArrayHelper::getColumn($item ->getRestaurants()->asArray()->all(), 'id');




    }

    /**
     * @param Vacancy $item
     * @return bool
     */
    public function edit($item){


        if ($this->validate()){



            $item->title=$this->title;
            $item->description=$this->description;



            if ($item->save()){

                $item->unlinkAll('restaurants',true);

                if ($this->restaurants_array && count($this->restaurants_array)>0 )

                {



                    foreach ($this->restaurants_array as $restaurant_id){

                        if ($restaurant = Restaurant::findOne($restaurant_id)){

                            $restaurant->link('vacancies',$item);
                        }
                    }



                }



                return true;
            }


        }

        return false;


    }


    /**
     * @return bool|Vacancy
     */

    public function create(){

        if ($this->validate()){

            $item = new Vacancy();

            $item->title=$this->title;
            $item->description=$this->description;






            if ($item->save()){

                if ($this->restaurants_array && count($this->restaurants_array)>0 )

                {



                    foreach ($this->restaurants_array as $restaurant_id){

                        if ($restaurant = Restaurant::findOne($restaurant_id)){

                            $restaurant->link('vacancies',$item);
                        }
                    }



                }

                return $item;
            }


        }

        return false;
    }
}