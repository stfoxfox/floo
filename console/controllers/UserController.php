<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 28/02/2017
 * Time: 22:24
 */

namespace console\controllers;


use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyFileSystem;

use common\components\MyExtensions\MyHelper;
use common\models\Order;
use common\models\User;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class UserController extends Controller
{




    public function actionCheckPayments(){


        $orders = Order::find()->with(['restaurant']) ->where(['payment_type'=>Order::PAYMENT_TYPE_CARD,'payment_status'=>Order::PAYMENT_STATUS_WAIT])->all();

        /**
         * @var Order $order
         */

        foreach ($orders as $order){


            $restaurant = $order->restaurant;

            if ($organisation =$restaurant->organisation) {


                try{
                $merchantUser = $organisation->sber_user;
                $merchantPass = $organisation->sber_pass;
                $arrReq = array();

                $arrReq['userName'] = $merchantUser;
                $arrReq['password'] = $merchantPass;// Идентификатор магазина
                $arrReq['orderId'] = $order->sber_id;

                $query = http_build_query($arrReq);

                //$orderUrl = 'https://3dsec.sberbank.ru/payment/rest/getOrderStatus.do?'.$query;
                    $orderUrl = 'https://securepayments.sberbank.ru/payment/rest/getOrderStatus.do?'.$query;
                $orderJ = json_decode(file_get_contents($orderUrl),true);

                    $orderStatus = ArrayHelper::getValue($orderJ,'OrderStatus',6);

                    switch ($orderStatus){

                        case 0:
                        {

                        }
                        break;
                        case 1:
                        case 2:

                        {
                            $order->payment_status=Order::PAYMENT_STATUS_PAID;

                            $order->save();
                            $order->generateXML(true);
                        }
                        break;
                        case 3:
                        case 4:
                        case 6:
                    {
                        $order->payment_status=Order::PAYMENT_STATUS_BAD;
                        $order->save();
                        $order->generateXML(true);
                    }break;

                    }


                } catch (\Exception $exception){

                    MyError::sendErrorMessage("Проблемы с проверкой статуса оплаты:".$order->id.$exception->getMessage());

                    $order->payment_status=Order::PAYMENT_STATUS_BAD;
                    $order->save();
                }

            }

            else{
                MyError::sendErrorMessage("Проблемы с проверкой статуса оплаты:".$order->id);

                $order->payment_status=Order::PAYMENT_STATUS_BAD;
                $order->save();
                //$order->generateXML(true);
            }



        }
        echo count($orders);


    }

    public function actionImportPoints(){


                try{

                    $date = date('Y-m-d',strtotime("-2 days"));
                    $users = json_decode(file_get_contents("https://jupiter.report/bonus/get_change.php?format=json&key=2cf3b01d7e6eb741a6259d7b07ad1b7a&date={$date}"),true);




                    foreach ($users as $userXml ){


                        $ext_user_id =  $userXml['client_id'];
                        $user_bonus = $userXml['balance_total'];
                        $userPhone = $userXml['phone'];

                        /**
                         * @var User $user
                         */
                        $user = User::find()->where(['ext_uuid'=>$ext_user_id])->one();

                        $user_found_by_phone=false;
                        if (!$user){

                            $user=User::find()->where(['username'=>MyHelper::preparePhone($userPhone)])->one();
                            $user_found_by_phone=true;
                        }

                        if ($user){

                            $user->balance =$user_bonus;
                            if ($user_found_by_phone){
                                $user->ext_uuid=$ext_user_id;
                            }
                            $user->save();
                        }
                        else{


                            $user = new User();
                            $user->username = MyHelper::preparePhone($userPhone);
                            $password =$this->randomString(4);
                            $user->setPassword($password);
                            $user->generateAuthKey();
                            $user->ext_uuid=$ext_user_id;
                            $user->balance =$user_bonus;
                            $user->status= User::STATUS_NOT_CONFIRMED;
                            $user->save(false);

                        }


                    }


                    //unlink(dirname(__FILE__) . '/../../xml/FROM_JUPITER/' . $file);
                    //rename(dirname(__FILE__) . '/../../xml/FROM_JUPITER/' . $file, $this->_saveTo . '/' . $file);
                }
                catch (\Exception $exception){

                    MyError::sendErrorMessage("Проблемы со структурой файла балов".$exception->getMessage());



                }






    }


    public static function xml2array($xml)
    {
        return simplexml_load_string($xml);
    }

    function randomString($length = 6) {
        $str = "";
        $characters = array_merge(  range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }



    public function actionTest(){


            print_r(MyHelper::sendSms("fff2","79091582149"));


    }
}