<?php

namespace common\models\BaseModels;

use common\models\ExternalSite;
use Yii;

/**
 * This is the model class for table "promo".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $description_short
 * @property integer $sort
 * @property boolean $for_all_restaurants
 * @property boolean $active
 * @property string $file_name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $action_type
 * @property integer $discount
 * @property double $min_order
 * @property integer $external_site_id
 * @property string $site_banner_fine_name
 */
class PromoBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'description_short'], 'string'],
            [['sort', 'action_type', 'discount', 'external_site_id'], 'integer'],
            [['for_all_restaurants', 'active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['min_order'], 'number'],
            [['title', 'file_name', 'site_banner_fine_name'], 'string', 'max' => 255],
            [['external_site_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExternalSite::className(), 'targetAttribute' => ['external_site_id' => 'id']],
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
            'description' => 'Description',
            'description_short' => 'Description Short',
            'sort' => 'Sort',
            'for_all_restaurants' => 'For All Restaurants',
            'active' => 'Active',
            'file_name' => 'File Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'action_type' => 'Action Type',
            'discount' => 'Discount',
            'min_order' => 'Min Order',
            'external_site_id' => 'External Site ID',
            'site_banner_fine_name' => 'Site Banner Fine Name',
        ];
    }
}
