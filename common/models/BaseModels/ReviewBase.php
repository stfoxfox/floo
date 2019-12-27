<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property integer $id
 * @property string $name
 * @property integer $restaiurant_id
 * @property string $review_text
 * @property string $phone
 * @property string $file_name
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class ReviewBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'review_text', 'phone', 'restaurant_id'], 'required'],
            [['restaurant_id'], 'integer'],
            [['review_text'], 'string'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'phone', 'file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'restaurant_id' => 'Restaurant Id',
            'review_text' => 'Review Text',
            'phone' => 'Phone',
            'file_name' => 'File Name',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
