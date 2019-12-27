<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 18/12/2016
 * Time: 23:53
 */

namespace api\controllers;


use common\components\controllers\ApiController;
use common\components\filters\ApiAccessControl;
use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyHelper;
use common\models\Address;
use common\models\ChangePhoneRequest;
use common\models\Order;
use common\models\User;
use common\models\UserAuth;
use yii\db\Expression;

class ProfileController extends ApiController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' =>ApiAccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],

            ],
            /** 'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
            'get-user-coins-info' => ['get'],
            'get-cities' => ['get'],
            ],
            ],*/


        ];
    }



    public function actionOrdersList(){


        /**
         * @var User $user
         * @var Order $order
         */

        $user = \Yii::$app->user->getIdentity();


        $orders = $user->getOrders()->orderBy('created_at DESC')->limit(30)->all();

        $returnArray = array();
        foreach ($orders as $order){

            $returnArray[] = $order->getListJson();

        }

        return $this->sendResponse(['items'=>$returnArray]);

    }

    public function  actionOrderDetails($id){

        if ($order = Order::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])){


            return $this->sendResponse(
                $order->getJson()
            );
        }

        return $this->sendError(MyError::BAD_REQUEST);

    }


    public function actionLogout(){

        $userAuth = UserAuth::findOne(['user_token'=>$this->user_token]);

        if($userAuth){

            $userAuth->delete();

            return  $this->sendResponse(['success'=>true]);

        }
        return $this->sendError(MyError::BAD_REQUEST);
    }


    public function actionGetInfo(){



        /**
         * @var User $user
         */

        $user = \Yii::$app->user->getIdentity();

        $returnArray= array(
            'user'=>$user->getUserMidi(),
        );


        if ($user->addresses){

            $addresses = array();
            /**
             * @var Address $address;
             */
            foreach ($user->addresses as $address){
                $addresses[]= $address ->getJson();
            }

            $returnArray['addresses']= $addresses;
        }

        /**
         * @var User $user
         */
        $user =\Yii::$app->user->getIdentity();

        $returnArray['orders_number']=$user->getOrders()->count();

        return $this->sendResponse($returnArray
        );

    }

    public function actionChangeName(){

        $name = \Yii::$app->request->post('name',null);


            /**
             * @var User $user
             */
            $user = \Yii::$app->user->getIdentity();

            $user->name = $name;

            if ($user->save()){
                $user->generateXml();

                return $this->sendSuccess();}


        return $this->sendError();
    }


    public function actionDellAddress(){

        $address_id =\Yii::$app->request->post('address_id');

        if ($address_id && $address = Address::findOne(['id'=>$address_id,'user_id'=>\Yii::$app->user->id]) ){

            if ($address->delete()){

                return $this->sendSuccess();
            }


        }


        return $this->sendError(MyError::BAD_REQUEST);
    }


    public function actionAddAddress(){


        $address = \Yii::$app->request->post('address');
        $full_address = \Yii::$app->request->post('full_address');
        $lng = \Yii::$app->request->post('lng');
        $lat = \Yii::$app->request->post('lat');


        if ($address && $lng && $lat){

            $item = new Address();

            $item->lng= $lng;
            $item->lat=$lat;
            $item->address=$address;
            $item->full_address=$full_address;
            $item->user_id=\Yii::$app->user->id;
            $item->location= new Expression("ST_GeomFromText('POINT({$item->lng}  {$item->lat} )',4326)");

            if ($item->save()){

                return $this->sendSuccess();
            }

        }


        return $this->sendError(MyError::BAD_REQUEST);

    }


    public function actionCreateChangePhoneRequest(){



        $phone= \Yii::$app->request->post('phone');

        if ($phone) {

            $phone= MyHelper::preparePhone($phone);
            $user = User::find()->where(['username' => $phone])->one();
            if ($user) {

                return $this->sendError(MyError::USER_REGISTRATION_USER_NAME_TAKEN);
            }
            else{

                $item = new ChangePhoneRequest();
                $item->new_phone=$phone;
                $item->user_id=\Yii::$app->user->id;
                $password =$this->randomString(4);

                MyHelper::sendSms("Ваш пароль: " . $password,$phone);
                $item->password_hash=\Yii::$app->security->generatePasswordHash($password);
                if ($item->save()){

                    return $this->sendResponse([
                        'id'=>$item->id,
                        'pass'=>$password,

                    ]);
                }

            }
        }


        return $this->sendError();
    }

    public function actionConfirmChangePhoneRequest(){


        $request_id = \Yii::$app->request->post('id');
        $password = \Yii::$app->request->post('password');


        if ($request_id && $password && $request = ChangePhoneRequest::findOne($request_id) ){

            if ($request->user_id== \Yii::$app->user->id && $request->validatePassword($password)){

                /**
                 * @var User $user
                 */
                $user= \Yii::$app->user->getIdentity();
                $user->username=$request->new_phone;
                if ($user->save()){

                    return $this->sendSuccess();
                }



            }
        }

        return $this->sendError();

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

}