<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 22.10.15
 * Time: 21:37
 */

namespace common\components\MyExtensions;


use filsh\yii2\gearman\JobWorkload;
use yii\base\Model;

class MyMailer extends Model
{

    public static function asyncSend($message){

        $message ->send();

    }

   public static function sendMail($to,$view,$params,$subject){


       $msg = \Yii::$app->mailer
           ->compose($view, $params)
           ->setFrom("robot@resho.ru")
           ->setTo($to)
           ->setSubject($subject);



       try {
           $job = new JobWorkload([
               'params'
               => $msg
           ]);


           \Yii::$app->gearman->getDispatcher()->background('SendMail', $job);
       }
       catch(\Exception $e){
           $msg->send();
       }



   }

}