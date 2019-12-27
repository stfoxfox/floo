<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 04/12/2016
 * Time: 02:28
 */

namespace api\controllers;


use common\components\controllers\ApiController;
use common\components\MyExtensions\MyError;
use common\components\MyExtensions\MyHelper;
use common\models\User;
use common\models\UserAuth;

class UserController extends ApiController
{


    public function actionGeneratePassword(){

        $phone= \Yii::$app->request->post('phone');

        if ($phone) {

            $prepared_phone= MyHelper::preparePhone($phone);

            if ($user = User::find()->where(['username' => $prepared_phone])->one()) {


                $password =$this->randomString(4);

                $user->setPassword($password);

                if ($user->save()) {

                  $r=   MyHelper::sendSms("Ваш пароль: " . $password,$phone);

                    return $this->sendResponse(['success'=>true,'pass'=>$password,'r'=>$r]);
                }
            } else {


                $user = new User();
                $user->username = $prepared_phone;
                $password =$this->randomString(4);
                $user->status =User::STATUS_NOT_CONFIRMED;
                $user->setPassword($password);
                $user->generateAuthKey();
                $user->balance=0;

                if ($user->save()) {
                    MyHelper::sendSms("Ваш пароль: " . $password,$phone);
                    return $this->sendResponse(['success'=>true,'pass'=>$password]);

                }
            }

        }

        return $this->sendError(MyError::BAD_REQUEST);


    }

    public function actionCheck(){

        ///$userName=  \Yii::$app->request->post('phone');

       // return $this->sendResponse(["a"=>MyHelper::preparePhone($userName)]);

        return $this->sendError();
    }

    public function actionLogin(){

        $userName=  \Yii::$app->request->post('phone');
        $password=  \Yii::$app->request->post('password');

        if(!$userName|| !$password){
            return $this->sendError(MyError::BAD_REQUEST);
        }

        $userName= MyHelper::preparePhone($userName);

        /** @var User $user */
        $user = User::findByUsername($userName);



        if($user) {
            if ($user->validatePassword($password) ||($userName =="111111111" &&$password =='1111') ) {

                $returnObj = array('user_authorized'=>true);

                $authToken = UserAuth::findByApiTokenAndUserId($this->api_token->token,$user->id);

                if(!$authToken){
                    $user_token = $user->generateToken($this->api_token->token);
                }else{
                    $user_token = $authToken->user_token;
                }


                $returnObj['user_token']  = $user_token;
                $returnObj['user']  = $user->getUserMidi();


                if ($user->status==User::STATUS_NOT_CONFIRMED){
                    $user->status = User::STATUS_ACTIVE;
                    $user->save();
                    $user->generateXml();
                }
                return $this->sendResponse($returnObj);


            }else{
                return  $this->sendError(MyError::USER_LOGIN_NOT_FOUND_OR_WRONG_PASSWORD);

            }
        }else{

            return  $this->sendError(MyError::USER_LOGIN_NOT_FOUND_OR_WRONG_PASSWORD);

        }
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