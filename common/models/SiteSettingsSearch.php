<?php
namespace common\models;
use yii\data\ActiveDataProvider;

/**
 * Class SiteSettingsSearch
 * @package common\models
 * @inheritdoc
 */
class SiteSettingsSearch extends SiteSettings
{
    /**
     * @inheritdoc
     */
    public function scenarios() {
        return parent::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params) {
        $model=self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        $this->setAttributes($params);
        if(!$this->validate()) {
            return $dataProvider;
        }

        if ($this->parent_id) {
            $model->andWhere(['parent_id' => $this->parent_id]);
        } else {
            $model->andWhere(['is', 'parent_id', null]);
        }

        $model->addOrderBy('type');

        return $dataProvider;
    }
}