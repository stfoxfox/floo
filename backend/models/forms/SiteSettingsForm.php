<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 06/08/2017
 * Time: 21:27
 */

namespace backend\models\forms;


use common\models\SiteSettings;
use common\components\MyExtensions\MyFileSystem;
use yii\base\Model;
use yii\web\UploadedFile;

class SiteSettingsForm extends Model
{
    public $file_name;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['file_name'], 'string', 'max' => 255],
            ['file_name', 'file',
                'extensions' => 'jpg, jpeg, png, pdf',
                'mimeTypes' => 'image/jpeg, image/png, image/gif, application/pdf',
                'maxFiles' => 1
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'file_name' => 'Файл',
        ];
    }

    /**
     * @param $item
     * @return null
     */
    public function loadFromItem($item) {
        return null;
    }

    /**
     * @param SiteSettings $item
     * @return bool|null
     */
    public function edit($item) {
        if (!$this->validate()) {
            return false;
        }

        $file_name_old = false;
        if ($file_name = UploadedFile::getInstance($this, 'file_name')) {
            $file_name_old= $item->uploadTo('file_name');
            $item->file_name = uniqid() . '_' . md5($file_name->name) . ".{$file_name->extension}";
        }

        if ($item->save()) {
            if ($file_name) {
                if ($file_name_old) {
                    unlink($file_name_old);
                }
                $file_name->saveAs(MyFileSystem::makeDirs($item->uploadTo('file_name')));
            }

            return true;
        }

        return null;
    }


}