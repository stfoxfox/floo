<?php

namespace common\models\BaseModels;

use common\models\CatalogItemModificator;
use Yii;

/**
 * This is the model class for table "modificator_item_image".
 *
 * @property integer $id
 * @property integer $modificator_item_id
 * @property integer $sort
 * @property string $file_name
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ModificatorItemImage $modificatorItem
 */
class ModificatorItemImageBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modificator_item_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modificator_item_id', 'sort'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
            [['modificator_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogItemModificator::className(), 'targetAttribute' => ['modificator_item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'modificator_item_id' => 'modificator Item ID',
            'sort' => 'Sort',
            'file_name' => 'File Name',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogItemModificator()
    {
        return $this->hasOne(CatalogItemModificator::className(), ['id' => 'modificator_item_id']);
    }
}
