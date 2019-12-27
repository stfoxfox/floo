<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 23/11/2016
 * Time: 01:08
 */

namespace backend\models\forms;


use common\components\MyExtensions\MyFileSystem;
use common\models\Setting;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\imagine\Image;

class SettingForm extends Model
{
    public $title;
    public $key;
    public $type;
    public $value;

    public $x;
    public $y;
    public $w;
    public $h;

    public $value_image;
    public $value_image_x;
    public $value_image_y;
    public $value_image_w;
    public $value_image_h;

    public function rules()
    {
        return [
            [['key', 'type', 'title'], 'required'],
            [['key', 'title'], 'string'],
            [['type', 'value', 'value_image'], 'safe'],
            [['value_image_x', 'value_image_y', 'value_image_w', 'value_image_h',], 'number']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'key' => 'Ключ',
            'type' => 'Тип',
            'value' => 'Значение',
            'value_image' => 'Значение'
        ];
    }

    /**
     * @param Setting $item
     */
    public function loadFromItem($item){
        $this->title = $item->title;
        $this->key = $item->key;
        $this->type = $item->type;
        $this->value = $item->value;
        if($item->type == "image"){
            $this->value_image = $this->value;
        }
    }

    /**
     * @param Setting $item
     * @return bool|Setting
     */
    public function saveItem($item){
        if ($this->validate()) {
            $item->title = $this->title;
            $item->key = $this->key;
            $item->type = $this->type;
            $item->value = $this->value;
            
            if($item->type == 'image' && $picture =UploadedFile::getInstance($this,'value_image')) {
                $old_file_path = $item->uploadTo('value');
                $item->value = uniqid()."_".md5($picture->name).".".$picture->extension;
                $cropImage = Image::crop(
                    $picture->tempName, 
                    intval($this->value_image_w), 
                    intval($this->value_image_h), 
                    [ intval($this->value_image_x), intval($this->value_image_y)]
                );
            }
            if ($item->save()){
                if ($old_file_path && file_exists($old_file_path)){
                    unlink($old_file_path);
                }
                
                if ($cropImage){
                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('value')));
                }
                return $item;
            }
        }
        return false;
    }


    /**
     * @return bool|Setting
     */
    public function createItem(){
        if ($this->validate()){
            $item = new Setting();

            $item->title=$this->title;
            $item->key =$this->key;
            $item->type = $this->type;
            $item->value = $this->value;

            $cropImage = false;

            if($item->type == "image" && $picture =UploadedFile::getInstance($this,'value_image')) {
                $item->value = uniqid()."_".md5($picture->name).".".$picture->extension;
                $cropImage = Image::crop(
                    $picture->tempName, 
                    intval($this->value_image_w), 
                    intval($this->value_image_h), 
                    [intval($this->value_image_x), intval($this->value_image_y)]
                );

                if ($cropImage){
                    $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('value')));
                }
            }

            if ($item->save()){
                Setting::setItemInCache([$item->key => $item->value]);
                return $item;
            }else {
                var_dump($item->getErrors());
            }
        }
        return false;
    }

        /**
     * @param Promo $item
     * @return bool
     */
    public function editSetting($item){
        if ($this->validate()){
            $item->title=$this->title;
            $item->key =$this->key;
            $item->type = $this->type;
            

            $cropImage = false;
            if($item->type == "image"){
                if($picture =UploadedFile::getInstance($this,'value_image')) {
                    $item->value = uniqid()."_".md5($picture->name).".".$picture->extension;
                    $cropImage = Image::crop(
                        $picture->tempName,
                        intval($this->value_image_w),
                        intval($this->value_image_h),
                        [intval($this->value_image_x), intval($this->value_image_y)]
                    );

                    if ($cropImage){
                        $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('value')));
                    }
                }
            }else{
                $item->value = $this->value;
            }

            if ($item->save()){    
                Setting::setItemInCache([$item->key => $item->value]);            
                return $item;
            }
            else{
                print_r($item->getErrors());
                exit;
            }
        }

        return false;


    }

    
}