<?php

namespace backend\models\forms;

use common\components\MyExtensions\MyFileSystem;
use common\components\MyExtensions\MyImagePublisher;
use common\models\BlogPostBlock;
use common\models\BlogPostBlockImage;
use common\models\CatalogItemModificator;
use common\models\Gallery;
use common\models\PageBlock;
use common\models\PageBlockImage;
use common\models\SpotPicture;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

class GalleryForm extends  Model
{
    public $file_name;
    public $image_id;
    public $_model;
    public $item_id;
    public $text;
    public $x;
    public $y;
    public $w;
    public $h;

    public function rules()
    {
        return [
            [['file_name', 'item_id', 'image_id', 'x', 'y', 'w', 'h', 'text'], 'safe'],
            [['file_name'], 'file', 'extensions' => ['jpg', 'png'], 'maxFiles' => 1],
        ];
    }

    /**
     * @return Gallery|null
     */
    public function createPicture()
    {
        if ($this->validate()) {
            if ($this->image_id && $this->image_id!=0){

                $item = Gallery::findOne($this->image_id);
                if ($item){
                    $old_file=$item->uploadTo('file_name');
                    $item->file_name = uniqid() . "_" . md5($old_file) . "." . pathinfo($old_file,PATHINFO_EXTENSION);
                    $item->save();

                    $cropImage = Image::crop(
                        $old_file, 
                        intval($this->w) >= 0 ? intval($this->w) : 0, 
                        intval($this->h) >= 0 ? intval($this->h) : 0, [
                            intval($this->x) >= 0 ? intval($this->x) : 0, 
                            intval($this->y) >= 0 ? intval($this->y) : 0
                        ]
                    );
                    if ($cropImage) {
                        $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));
                    }
                    unlink($old_file);
                    //(new MyImagePublisher($item))->flushCache();
                }
            }else{
                $item = new Gallery();

                $item->sort = 0;

                $cropImage = false;
                if ($picture = UploadedFile::getInstance($this, 'file_name')) {
                    $item->file_name = uniqid() . "_" . md5($picture->name) . "." . $picture->extension;
                    $cropImage = Image::crop(
                        $old_file, 
                        intval($this->w) >= 0 ? intval($this->w) : 0, 
                        intval($this->h) >= 0 ? intval($this->h) : 0, [
                            intval($this->x) >= 0 ? intval($this->x) : 0, 
                            intval($this->y) >= 0 ? intval($this->y) : 0
                        ]
                    );
                }

                if ($item->save()) {
                    if ($cropImage) {
                        $cropImage->save(MyFileSystem::makeDirs($item->uploadTo('file_name')));
                    }
                    return $item;
                }
            }
        }

        return null;
    }

}