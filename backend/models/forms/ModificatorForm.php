<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 27/11/2016
 * Time: 20:24
 */

namespace backend\models\forms;

use common\components\MyExtensions\MyFileSystem;
use common\models\CatalogItemModificator;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;

class ModificatorForm extends Model 
{

    public $title;
    public $price;
    public $icon;
    public $ext_code;
    public $description;
    public $photo;
    public $active;
    public $video_link;

    public $photo_x;
    public $photo_y;
    public $photo_w;
    public $photo_h;    


    public function rules()
    {
        return [
            [['title', 'price', 'ext_code'], 'required'],
            [['icon', 'photo', 'description', 'video_link'], 'safe'],
            [['photo_x', 'photo_y', 'photo_w', 'photo_h',], 'number'],
            [['active'], 'integer']
        ];
    }


    public function attributeLabels()
    {
        return [

            'title' => 'Название',
            'price' => 'Цена',
            'icon' => 'Иконка',
            'ext_code' => 'Код Юпитера',
            'description' => 'Описание',
            'photo' => 'Фотография',
            'video_link' => 'Ссылка на видео',
            'active' => 'Активен'
        ];
    }


    /**
     * @param CatalogItemModificator $item
     */
    public function loadFromItem($item){
        $this->title = $item->title;
        $this->price = $item->price;
        $this->icon = $item->icon;
        $this->ext_code = $item->ext_code;
        $this->description = $item->description;
        $this->photo = $item->photo;
        $this->video_link = $item->video_link;
        $this->active = $item->active;
    }



    public  function  createModificator(){

        if ($this->validate()){

            $newModificator = new CatalogItemModificator();

            $newModificator->title=$this->title;
            $newModificator->price=$this->price;
            $newModificator->icon=$this->icon;
            $newModificator->ext_code=$this->ext_code;
            $newModificator->description=$this->description;
            $newModificator->video_link = $this->video_link;
            $newModificator->active = $this->active;
            //$newModificator->photo=$this->photo;

            if($picture =UploadedFile::getInstance($this,'photo')) {
                $newModificator->photo = uniqid()."_".md5($picture->name).".".$picture->extension;
                $cropImage = Image::crop(
                    $picture->tempName, 
                    intval($this->photo_w), 
                    intval($this->photo_h), 
                    [intval($this->photo_x) < 0 ? 0 : intval($this->photo_x), intval($this->photo_y) < 0 ? 0 : intval($this->photo_y)]
                );

                if ($cropImage){
                    $cropImage->save(MyFileSystem::makeDirs($newModificator->uploadTo('photo')));
                }
            }

            if ($newModificator->save()){
                return $newModificator;
            }
        }
        
        return false;
    }    

    /**
     * @param CatalogItemModificator $item
     * @return bool
     */
    public function editModificator($item){
        if ($this->validate()){

            $item->title=$this->title;
            $item->price=$this->price;
            $item->icon=$this->icon;
            $item->ext_code=$this->ext_code;
            $item->description=$this->description;
            $item->video_link = $this->video_link;
            $item->active = $this->active;

            if($picture =UploadedFile::getInstance($this,'photo')) {
                $item->photo = uniqid()."_".md5($picture->name).".".$picture->extension;
                $cropImage = Image::crop(
                    $picture->tempName, 
                    intval($this->photo_w), 
                    intval($this->photo_h), 
                    [intval($this->photo_x) < 0 ? 0 : intval($this->photo_x), intval($this->photo_y) < 0 ? 0 : intval($this->photo_y)]
                );

                if ($cropImage){
                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('photo')));
                }
            }

            if ($item->save()){
                return $item;
            }
        }
        
        return false;
    }

}