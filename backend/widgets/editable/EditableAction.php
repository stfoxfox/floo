<?php

namespace backend\widgets\editable;

use backend\models\forms\ArLinkedFormInterface;
use Yii;
use yii\base\Action;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * @author Albert Garipov <bert320@gmail.com>
 */
class EditableAction extends Action
{

    /**
     * @var string
     */
    public $formClass;

    /**
     * @var string
     */
    public $modelClass;

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function run()
    {
        Yii::$app->response->format = 'json';


        // collect data
        $pk = Yii::$app->request->post('pk');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        if ($name === null || $value === null) {
            throw new BadRequestHttpException('No data.');
        }


        // get model
        $modelClass = $this->modelClass;
        $model = $modelClass::find()->where(['id' => $pk])->one();
        if ($model === null) {
            throw new NotFoundHttpException('Запись не найдена');
        }

        // create form
        $formClass = $this->formClass;
        /* @var $form \yii\db\ActiveRecord */
        $form = new $formClass();
        $form->loadFrom($model);


        // set safe attribute
        $form->setAttributes([$name => $value]);

        
        // save model
        if ($form->edit($model)) {
            return ['success' => true];
        } else {
            Yii::$app->response->statusCode = 422;

            $lines = [];
            foreach ($form->getErrors() as $errors) {
                foreach ($errors as $error) {
                    if (!in_array($error, $lines, true)) {
                        $lines[] = $error;
                    }
                }
            }

            return join('; ', $lines);
        }
    }

}