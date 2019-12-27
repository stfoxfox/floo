<?php

namespace common\models\BaseModels;

use common\models\Vacancy;
use Yii;

/**
 * This is the model class for table "vacancy_response".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $info
 * @property string $file_name
 * @property integer $vacancy_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Vacancy $vacancy
 */
class VacancyResponseBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vacancy_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'vacancy_id'], 'required'],
            [['vacancy_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'phone', 'info', 'file_name'], 'string', 'max' => 255],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
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
            'phone' => 'Phone',
            'info' => 'Info',
            'file_name' => 'File Name',
            'vacancy_id' => 'Vacancy ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::className(), ['id' => 'vacancy_id']);
    }
}
