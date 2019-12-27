<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "external_site".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 */
class ExternalSiteBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'external_site';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['title', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
        ];
    }
}
