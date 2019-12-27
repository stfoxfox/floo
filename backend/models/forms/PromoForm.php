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
use yii\base\Model;
use common\models\Promo;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class PromoForm extends Model
{


    public $title;
    public $description;
    public $description_short;
    public $for_all_restaurants;
    public $active;
    public $file_name;
    public $action_type;
    public $discount;
    public $min_order;
    public $site_id;

    public $restaurants_array= array();
    public $items_array =array();

    public $x;
    public $y;
    public $w;
    public $h;


    public $site_banner_fine_name;
    public $site_banner_fine_name_x;
    public $site_banner_fine_name_y;
    public $site_banner_fine_name_w;
    public $site_banner_fine_name_h;



    public function rules()
    {
        return [

            ['title', 'required'],

            ['title', 'filter', 'filter' => 'trim'],
            ['description', 'filter', 'filter' => 'trim'],
            ['description_short', 'filter', 'filter' => 'trim'],
            [['x','y','w','h'], 'safe'],
            [['site_banner_fine_name_x','site_banner_fine_name_y','site_banner_fine_name_w','site_banner_fine_name_h'], 'safe'],
            ['restaurants_array', 'safe'],
            ['items_array', 'safe'],
            ['for_all_restaurants', 'safe'],
            ['action_type', 'safe'],
            ['site_id', 'safe'],
            ['discount', 'safe'],
            ['min_order', 'safe'],
            ['file_name', 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg','png'],'maxFiles'=>1],
            [['site_banner_fine_name'], 'string', 'max' => 255],
            [['site_banner_fine_name'], 'file', 'extensions' => ['jpg','png'],'maxFiles'=>1],
            ['active','boolean'],


        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Название Акции',
            'description' => 'Описание',
            'description_short' => 'Краткое описание',
            'for_all_restaurants' => 'Действует для всех ресторанов',
            'active' => 'Активная',
            'file_name' => 'Картинка акции',
        ];
    }


    /**
     * @param Promo $item
     */
    public function loadFormItem($item){

        $this->title=$item->title;
        $this->description=$item->description;
        $this->description_short=$item->description_short;
        $this->for_all_restaurants=$item->for_all_restaurants;
        $this->action_type=$item->action_type;
        $this->discount=$item->discount;
        $this->min_order=$item->min_order;
        $this->site_id=$item->external_site_id;

        $this->restaurants_array= ArrayHelper::getColumn($item ->getRestaurants()->asArray()->all(), 'id');
        $this->items_array=ArrayHelper::getColumn($item->getCatalogItems()->asArray()->all(),'id');




    }

    /**
     * @param Promo $item
     * @return bool
     */
    public function editPromo($item){


        if ($this->validate()){



            $item->title=$this->title;
            $item->description=$this->description;
            $item->description_short=$this->description_short;
            $item->for_all_restaurants=$this->for_all_restaurants;
            $item->action_type=$this->action_type;
            $item->discount=$this->discount;
            $item->min_order=$this->min_order;

            $item->external_site_id=  $this->site_id;



            $cropImage = false;

            if($picture =UploadedFile::getInstance($this,'file_name')) {

                $item->file_name = uniqid()."_".md5($picture->name).".".$picture->extension;




                $cropImage = Image::crop($picture->tempName,intval($this->w),intval($this->h),[intval($this->x),intval($this->y)]);




            }

             $cropImagesite_banner_fine_name = false;

            if($picture =UploadedFile::getInstance($this,'site_banner_fine_name')) {

                $item->site_banner_fine_name = uniqid()."_".md5($picture->name).".".$picture->extension;



                $cropImagesite_banner_fine_name = Image::crop($picture->tempName,intval($this->site_banner_fine_name_w),intval($this->site_banner_fine_name_h),[intval($this->site_banner_fine_name_x),intval($this->site_banner_fine_name_y)]);




            }


            if ($item->save()){

                if ($cropImage){

                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));


                }

                if ($cropImagesite_banner_fine_name){

                    $cropImagesite_banner_fine_name->save(MyFileSystem::makeDirs($item->uploadTo('site_banner_fine_name')));
                }

                $item->unlinkAll('restaurants',true);

                if ($this->restaurants_array && count($this->restaurants_array)>0 )

                {



                    foreach ($this->restaurants_array as $restaurant_id){

                        if ($restaurant = Restaurant::findOne($restaurant_id)){

                            $restaurant->link('promos',$item);
                        }
                    }



                }

                $item->unlinkAll('catalogItems',true);


                if ($this->items_array && count($this->items_array)>0 )
                {
                    foreach ($this->items_array as $item_id){

                        if ($catalog_item= CatalogItem::findOne($item_id)){

                            $catalog_item->link('promos',$item);
                        }
                    }



                }

                return $item;
            }
            else{
                print_r($item->getErrors());
                exit;
            }


        }

        return false;


    }


    /**
     * @return bool|Promo
     */

    public function createPromo(){

        if ($this->validate()){

            $item = new Promo();

            $item->title=$this->title;
            $item->description=$this->description;
            $item->description_short=$this->description_short;
            $item->for_all_restaurants=$this->for_all_restaurants;
            $item->action_type=$this->action_type;
            $item->discount=$this->discount;
            $item->min_order=$this->min_order;
            $item->external_site_id=  $this->site_id;





            $cropImage = false;

            if($picture =UploadedFile::getInstance($this,'file_name')) {

                $item->file_name = uniqid()."_".md5($picture->name).".".$picture->extension;




                $cropImage = Image::crop($picture->tempName,intval($this->w),intval($this->h),[intval($this->x),intval($this->y)]);




            }


            $cropImagesite_banner_fine_name = false;

            if($picture =UploadedFile::getInstance($this,'site_banner_fine_name')) {

                $item->site_banner_fine_name = uniqid()."_".md5($picture->name).".".$picture->extension;




                $cropImagesite_banner_fine_name = Image::crop($picture->tempName,intval($this->site_banner_fine_name_w),intval($this->site_banner_fine_name_h),[intval($this->site_banner_fine_name_x),intval($this->site_banner_fine_name_y)]);




            }



            if ($item->save()){

                if ($cropImage){

                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));
                }


                if ($cropImagesite_banner_fine_name){

                    $cropImagesite_banner_fine_name->save(MyFileSystem::makeDirs($item->uploadTo('site_banner_fine_name')));
                }

                if ($this->restaurants_array && count($this->restaurants_array)>0 )

                {



                    foreach ($this->restaurants_array as $restaurant_id){

                        if ($restaurant = Restaurant::findOne($restaurant_id)){

                            $restaurant->link('promos',$item);
                        }
                    }



                }

                if ($this->items_array && count($this->items_array)>0 )

                {



                    foreach ($this->items_array as $item_id){

                        if ($catalog_item= CatalogItem::findOne($item_id)){

                            $catalog_item->link('promos',$item);
                        }
                    }



                }

                return $item;
            }


        }

        return false;
    }
}