<?php

namespace common\models\BaseModels;

use common\models\Restaurant;
use common\models\VacancyResponse;
use Yii;

/**
 * This is the model class for table "vacancy".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $sort
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property VacancyResponse[] $vacancyResponses
 * @property VacancyRestaurantLink[] $vacancyRestaurantLinks
 * @property Restaurant[] $restaurants
 */
class VacancyBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['sort'], 'integer'],
            [['is_active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
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
            'sort' => 'Sort',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancyResponses()
    {
        return $this->hasMany(VacancyResponse::className(), ['vacancy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancyRestaurantLinks()
    {
        return $this->hasMany(VacancyRestaurantLink::className(), ['vacancy_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants()
    {
        return $this->hasMany(Restaurant::className(), ['id' => 'restaurant_id'])->viaTable('vacancy_restaurant_link', ['vacancy_id' => 'id']);
    }
}
