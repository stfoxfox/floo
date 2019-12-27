<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;

use Yii;
use common\components\MyExtensions\MyFileSystem;
use common\models\CatalogCategory;
use common\models\CatalogItem;
use common\models\CatalogItemModificator;
use common\models\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\imagine\Image;

class CatalogItemForm extends Model
{
    const CSS_CLASSES = [
        'main' => [
            'arrow' => 'arrow',
            'line' => 'line',
            'the' => 'the',
            'fire' => 'fire',
            'border' => 'border',
        ],
        'snacks' => [
            'sheet' => 'sheet',
            'sheet-2' => 'sheet-2', 
            'greek' => 'greek',
            'avocado' => 'avocado',
            'arugula' => 'arugula',
            'olivie' => 'olivie',
            'mozzarella' => 'mozzarella',
            'salmon' => 'salmon',
            'cheese' => 'cheese',
            'herring' => 'herring',
            'roll' => 'roll',
            'cheeseburger' => 'cheeseburger',
            'hamburger' => 'hamburger',
            'ribs' => 'ribs',
            'wings' => 'wings',
            'fish' => 'fish',
            'shrimp' => 'shrimp',
        ],
        'paste' => [
            'basta' => 'basta',
            'carbo' => 'carbo',
            'bol' => 'bol',
            'more' => 'more',
            'chik' => 'chik',
            'karne' => 'karne',
            'salmon' => 'salmon',
        ],
        'soup' => [
            'fichshr' => 'ligu',
            'ligu' => 'ligu',
            'pump' => 'pump',
            'rim' => 'rim',
            'shamp' => 'shamp',
            'sol' => 'sol',
        ],
        'hot' => [
            'pork' => 'pork', 
            'vakka' => 'vakka', 
            'skamor' => 'skamor',
            'sochchik' => 'sochchik',
            'befstrog' => 'befstrog',
            'stak' => 'stak',
            'staksem' => 'staksem',
            'ribasir' => 'ribasir',
            'jarmor' => 'jarmor',
        ],
        'pizza' => [
            '4sir' => '4sir', 
            'margo' => 'margo', 
            'prontis' => 'prontis',
            'cezar' => 'cezar',
            'cezar-2' => 'cezar-2',
            'bbq' => 'bbq',
            'mnogom' => 'mnogom',
            'salam' => 'salam',
            'mpir' => 'mpir',
            'div' => 'div',
            'paper' => 'paper',
            'vetch' => 'vetch',
            'calco' => 'calco',
            'gava' => 'gava',
        ],
        'dessert' => [
            'krep' => 'krep', 
            'ven' => 'ven', 
            'chizk' => 'chizk',
            'amore' => 'amore',
            'profi' => 'profi',
            'split' => 'split',
            'tiram' => 'tiram',
            'assort' => 'assort',
            'dolche' => 'dolche',
            'shar' => 'shar',
        ]
    ]; 

    public $title;
    public  $description;
    public $file_name;
    public $ext_code;
    public  $price;
    public  $packing_weights;
    public $category_id;
    public  $active;
    public $modificators;
    public  $tags;
    public  $add_all_modificators;
    public $css_class;
    public $is_main_page;
    public $in_basket_page;

    
    public  $price_st_st; 
    public $price_big_st; 
    public  $price_st_big; 
    public  $price_big_big; 
    public  $ext_code_st_st; 
    public  $ext_code_big_st; 
    public  $ext_code_st_big; 
    public  $ext_code_big_big;

    public $x;
    public $y;
    public $w;
    public $h;


    public function rules()
    {
        return [

            ['title', 'required'],

            ['title', 'filter', 'filter' => 'trim'],
            ['description', 'filter', 'filter' => 'trim'],
            ['ext_code', 'filter', 'filter' => 'trim'],
            ['price', 'filter', 'filter' => 'trim'],
            ['packing_weights', 'filter', 'filter' => 'trim'],
            ['category_id','integer'],
            //['category_id', 'required'],
            [['x','y','w','h'], 'safe'],
            [['price_st_st','price_big_st','price_st_big','price_big_big','ext_code_st_st','ext_code_big_st','ext_code_st_big','ext_code_big_big'], 'safe'],
            ['file_name', 'safe'],
            ['modificators', 'safe'],
            ['add_all_modificators', 'safe'],
            ['tags', 'safe'],
            [['file_name', 'css_class'], 'string', 'max' => 255],
            [['file_name'], 'file', 'extensions' => ['jpg','png'],'maxFiles'=>1],
            [['active', 'is_main_page', 'in_basket_page'],'boolean'],


        ];
    }


    /**
     * @param CatalogItem $item
     */
    public function loadFromItem($item){


        $this->title=$item->title;
        $this->active=$item->active;
        $this->description=$item->description;
        $this->ext_code=$item->ext_code;
        $this->price=$item->price;
        $this->packing_weights=$item->packing_weights;
        $this->category_id=$item->category_id;
        $this->css_class=$item->css_class;
        $this->is_main_page = $item->is_main_page;
        $this->in_basket_page = $item->in_basket_page;


        $this->price_st_st=$item->price_st_st;
        $this->price_big_big=$item->price_big_big;
        $this->price_big_st=$item->price_big_st;
        $this->price_st_big=$item->price_st_big;



        $this->ext_code_st_st=$item->ext_code_st_st;
        $this->ext_code_big_big=$item->ext_code_big_big;
        $this->ext_code_big_st=$item->ext_code_big_st;
        $this->ext_code_st_big=$item->ext_code_st_big;


        $this->tags= ArrayHelper::getColumn($item->getTags()->asArray()->all(), 'id');
        $this->modificators= ArrayHelper::getColumn($item->getModificators()->asArray()->all(), 'id');

    }

    /**
     * @param CatalogItem $item
     * @return bool|CatalogItem
     */

    public function saveItem($item){

        if ($this->validate()) {

            $old_file_path = Yii::getAlias('@common')."/uploads/catalog_items/{$item->category_id}/{$item->file_name}";

            $item->title=$this->title;
            $item->active =$this->active;
            $item->description=$this->description;
            $item->ext_code=$this->ext_code;
            $item->price=$this->price;
            $item->packing_weights=$this->packing_weights;
            $item->category_id=$this->category_id;
            $item->css_class=$this->css_class;
            $item->is_main_page = $this->is_main_page;
            $item->in_basket_page = $this->in_basket_page;


            $item->price_st_st=$this->price_st_st;
            $item->price_big_big=$this->price_big_big;
            $item->price_big_st=$this->price_big_st;
            $item->price_st_big=$this->price_st_big;



            $item->ext_code_st_st=$this->ext_code_st_st;
            $item->ext_code_big_big=$this->ext_code_big_big;
            $item->ext_code_big_st=$this->ext_code_big_st;
            $item->ext_code_st_big=$this->ext_code_st_big;

            $cropImage = false;
            //$old_file_path = false;

            
            
            if($picture =UploadedFile::getInstance($this,'file_name')) {

                $old_file_path = $item->uploadTo('file_name');
                $item->file_name = uniqid()."_".md5($picture->name).".".$picture->extension;

                $cropImage = Image::crop($picture->tempName,intval($this->w),intval($this->h),[intval($this->x),intval($this->y)]);


            }
            if ($item->save()){
                if ($cropImage){

                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));
                }else{
                    copy($old_file_path, Yii::getAlias('@common')."/uploads/catalog_items/{$item->category_id}/{$item->file_name}");
                }

                if ($old_file_path && file_exists($old_file_path)){
                //    unlink($old_file_path);
                }

                

                $item->unlinkAll('modificators',true);
                if ($this->add_all_modificators){

                    foreach (CatalogItemModificator::find()->all()as $modificator) {
                        $modificator->link('catalogItems',$item);

                    }
                }else
                if ($this->modificators)

                {

                    foreach ($this->modificators as $modificator_id){

                        if ($modificator = CatalogItemModificator::findOne($modificator_id)){

                            $modificator->link('catalogItems',$item);
                        }
                    }



                }


                $item->unlinkAll('tags',true);

                if ($this->tags){

                    foreach ($this->tags as $tag_id){

                        if ($tag = Tag::findOne($tag_id)){

                            $tag->link('catalogItems',$item);

                        }


                    }

                }

                //return $old_file_path;
                return $item;



            }


        }

        return false;
    }


    public function createItem(){

        if ($this->validate()){

            $item = new CatalogItem();

            $item->title=$this->title;
            $item->active =$this->active;
            $item->description=$this->description;
            $item->ext_code=$this->ext_code;
            $item->price=$this->price;
            $item->packing_weights=$this->packing_weights;
            $item->category_id=$this->category_id;
            $item->css_class=$this->css_class;
            $item->is_main_page = $this->is_main_page;
            $item->in_basket_page = $this->in_basket_page;
            
            $item->price_st_st=$this->price_st_st;
            $item->price_big_big=$this->price_big_big;
            $item->price_big_st=$this->price_big_st;
            $item->price_st_big=$this->price_st_big;



            $item->ext_code_st_st=$this->ext_code_st_st;
            $item->ext_code_big_big=$this->ext_code_big_big;
            $item->ext_code_big_st=$this->ext_code_big_st;
            $item->ext_code_st_big=$this->ext_code_st_big;

            $cropImage = false;

            if($picture =UploadedFile::getInstance($this,'file_name')) {

                $item->file_name = uniqid()."_".md5($picture->name).".".$picture->extension;




                $cropImage = Image::crop($picture->tempName,intval($this->w),intval($this->h),[intval($this->x),intval($this->y)]);








            }


            if ($item->save()){


                if ($cropImage){

                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));
                }

                if ($this->add_all_modificators){

                    foreach (CatalogItemModificator::find()->all()as $modificator) {
                        $modificator->link('catalogItems',$item);

                    }
                }else if ($this->modificators)

                {

                    foreach ($this->modificators as $modificator_id){

                        if ($modificator = CatalogItemModificator::findOne($modificator_id)){

                            $modificator->link('catalogItems',$item);
                        }
                    }



                }

                if ($this->tags){

                    foreach ($this->tags as $tag_id){

                        if ($tag = Tag::findOne($tag_id)){

                            $tag->link('catalogItems',$item);

                        }


                    }

                }


                return $item;
            }


        }


        return false;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название блюда',
            'description' => 'Описание',
            'css_class' => 'Иконка стрелок для названия',

            'file_name' => 'Фото',
            'ext_code' => 'Код в Юпитере',
            'price' => 'Цена',
            'category_id' => 'Категория',
            'active' => 'Активно',
            'is_main_page' => 'Отображать на главной странице',
            'in_basket_page' => 'Отображать в корзине',

            'add_all_modificators'=>'Подключить все модификаторы',
            'price_st_st'=>'Цена Стандартное тесто, стандартный размер',
            'price_big_st'=>'Цена Стандартное тесто, Большая',
            'price_st_big'=>'Цена Пышное тесто, стандартный размер',
            'price_big_big'=>'Цена Пышное тесто, Большая',

            'ext_code_st_st'=>'Код юпитера Стандартное тесто, стандартный размер',
            'ext_code_big_st'=>'Код юпитера Стандартное тесто, Большая',
            'ext_code_st_big'=>'Код юпитера Пышное тесто, стандартный размер',
            'ext_code_big_big'=>'Код юпитера Пышное тесто, Большая',

            'packing_weights'=>"Вес"

        ];
    }


}