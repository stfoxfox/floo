<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 13.08.15
 * Time: 19:31
 */
namespace common\components\MyExtensions;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class MyActiveRecord extends \yii\db\ActiveRecord {


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
        ]
        ];
    }

    public static function getAttributeEnums($attribute) {
        $return = array();

        $model_reflection = new \ReflectionClass(get_called_class());


        foreach($model_reflection->getConstants() as $constant=>$value) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {


                $return[$value] =  \Yii::t('models/'.strtolower($model_reflection->getShortName()),$constant);;

            }
        }


        return $return;
    }


    public function isAttributeEnumerable($attribute) {
        $ret = false;

        $model_reflection = new \ReflectionClass($this);
        foreach(array_keys($model_reflection->getConstants()) as $constant) {
            if (preg_match('/^'.strtoupper($attribute).'.+/', $constant)) {
                $ret = true;
            }
        }

        return $ret;
    }




}