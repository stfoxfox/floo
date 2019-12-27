<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\components\actions\Edit;
use common\components\controllers\BackendController;
use common\models\SiteSettings;
use common\models\SiteSettingsSearch;
use backend\models\forms\SiteSettingsForm;

/**
 * Class SiteSettingsController
 * @package backend\controllers
 */
class SettingController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'edit' => [
                'class' => Edit::className(),
                '_editForm' => SiteSettingsForm::className(),
                '_model' => SiteSettings::className(),
                'breadcrumbs' => [
                    ['label' => 'Управление настройками', 'url' => ['index']],
                    ['label' => 'Изменить']
                ]
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        $params = Yii::$app->request->queryParams;
        $models = (new SiteSettingsSearch())->search($params);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionItems($id) {
        $setting = $this->findModel($id);
        $params = ArrayHelper::merge(Yii::$app->request->queryParams, [
            'parent_id' => $setting->id,
        ]);
        $models = (new SiteSettingsSearch())->search($params);

        return $this->render('index', ['models' => $models]);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionItemEdit() {
        /** @var SiteSettings $item */
        $pk = Yii::$app->request->post('pk');
        $value = Yii::$app->request->post('value');

        if ($item = SiteSettings::findOne($pk)) {
            switch ($item->type) {
                case SiteSettings::SiteSettings_TypeString:
                    $item->string_value = $value;
                    break;

                case SiteSettings::SiteSettings_TypeText:
                    $item->text_value = $value;
                    break;

                case SiteSettings::SiteSettings_TypeNumber:
                    $item->number_value = $value;
                    break;

                default:
                    break;
            }

            if ($item->save()) {
                return $this->sendJSONResponse(['success' => true]);
            }
        }

        throw  new NotFoundHttpException('Элемент не найден');
    }

    /**
     * @param $id
     * @return SiteSettings
     * @throws NotFoundHttpException
     */
    protected function findModel($id) {
        $model = SiteSettings::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Настройка не найдена');
        }

        return $model;
    }
}