<?php

namespace common\models\BaseModels;

use Yii;

/**
 * This is the model class for table "organisation".
 *
 * @property integer $id
 * @property string $title
 * @property string $sber_user
 * @property string $sber_pass
 * @property string $platron_user
 * @property string $platron_pass
 * @property string $created_at
 * @property string $updated_at
 */
class OrganisationBase extends \common\components\MyExtensions\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organisation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'sber_user', 'sber_pass', 'platron_user', 'platron_pass'], 'string', 'max' => 255],
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
            'sber_user' => 'Sber User',
            'sber_pass' => 'Sber Pass',
            'platron_user' => 'Platron User',
            'platron_pass' => 'Platron Pass',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
