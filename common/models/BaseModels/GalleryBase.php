<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string $file_name
 * @property integer $sort
 * @property string $created_at
 * @property string $updated_at
 *
 */
class GalleryBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sort' => 'Sort',
            'file_name' => 'File Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
