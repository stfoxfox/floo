<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/11/2017
 * Time: 11:00
 */

namespace frontend\models\forms;


use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyHelper;
use common\models\Vacancy;
use yii\base\Model;

class VacancyForm extends Model
{



    public $name;
    public $phone;
    public $vacancy_id;
    public $comment;



    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'comment', 'vacancy_id'], 'required'],
            [['name', 'surname'], 'string', 'max' => 80],
            [['vacancy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vacancy::className(), 'targetAttribute' => ['vacancy_id' => 'id']],
        ];
    }



    public function submit(){



        $vacancy =Vacancy::findOne($this->vacancy_id);
        $message = "Вакансия: $vacancy->title
        Имя: $this->name
        Телефон: $this->phone
        Коментарий: $this->comment
        ";

        MyHelper::sendMessage($message,"Отклик на вакансию");




        return true;
    }

}