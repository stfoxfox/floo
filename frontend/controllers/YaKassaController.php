<?php 

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\components\MyExtensions\MyHelper;
use common\models\Order;
use common\models\Promo;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

use YandexCheckout\Client;

class YaKassaController extends FrontendController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'payment' => ['post'],
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'payment') {
            # code...
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionPayment(){



        $notification = \Yii::$app->request->getRawBody();

        $notificationObj = json_decode($notification,true);


        $orderNumber =  $notificationObj['object']['id'];//\Yii::$app->request->post('id');
        //$orderSum = \Yii::$app->request->post('amount[value]');

        if($notificationObj['object']['status'] == 'waiting_for_capture' && $notificationObj['object']['paid']  == true){

            $order=Order::find()->where(['sber_id'=>$orderNumber])->one() ;

            if ($order){
                $client = new Client();
                $client->setAuth('184812', 'live_A25CMUe6Yv1ozOUH5YKHnFjccpTf3qv1ZvOdcwl0238');
                $client->capturePayment(['amount' => $notificationObj['object']['amount'] ], $orderNumber, uniqid('', true));

                $order->payment_status = Order::PAYMENT_STATUS_PAID;
                $order->save();

             ///   MyHelper::sendSms("Заказ № {$order->id}. Оплачен" ,"9651864336,9651864336,4959332849");

                return true;
            }
        }

    }

}
?>