<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 18.10.15
 * Time: 15:01
 */

namespace api\controllers;


use common\components\controllers\ApiController;
use common\components\MyExtensions\MyError;
use common\models\ApiToken;
use common\models\NotificationsCounter;
use common\models\SiteSettings;
use common\models\User;
use common\models\UserAuth;
use yii\db\Exception;
use yii\db\Expression;
use yii\web\Response;
use yii\filters\VerbFilter;

class ApiClientController extends ApiController
{

    public function init() {

        \Yii::$app->response->format = Response::FORMAT_JSON;

    }

    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'init' => ['post'],
                ],
            ],
        ];
    }

   

    public function actionSaveDeviceToken(){


        $device_token=\Yii::$app->request->post('device_token');
        $device_type=\Yii::$app->request->post('device_type');
        $current_token = \Yii::$app->request->getHeaders()->get('x-ermioni-apitoken');;
        if($device_token && $device_type && $current_token &&  $token  = ApiToken::find()->where(['token'=>$current_token])->one()){

            $token->device_token=$device_token;
            $token->device_type=$device_type;

            if($token->save()){

                return $this->sendResponse(['success'=>true]);
            }
        }




        return $this->sendError(MyError::BAD_REQUEST);

    }

    
    public function actionInit(){

        $current_token = \Yii::$app->request->getHeaders()->get('x-pronto-apitoken');;
        $lang = \Yii::$app->request->post('lang');
        $device_type=\Yii::$app->request->post('device_type');
        $device_token=\Yii::$app->request->post('device_token');

        if(!$lang&&!$device_type){
            return $this->sendResponse(MyError::API_TOKEN_BAD_REQUEST);
        }

        $token = null;

        if($current_token){
            try{
            $token  = ApiToken::find()->where(['token'=>$current_token])->one();}
            catch (\Exception $e){
                
                
            }
        }

        if(!$token){
            $token = new ApiToken();


            $token->token=ApiToken::generateToken();
        }

        $token->device_type=$device_type;
        if($device_token) {
            $token->device_token=$device_token;
        }






        $token->lang=substr($lang, 0,2);




        if($token->save()){

            $responseObj = ['api_token'=>$token->token,];
            $authHeader = \Yii::$app->request->getHeaders()->get('x-pronto-authorization');
            $isAuth= false;
            if($authHeader){

                try{


                /** @var User $user */
                $user = User::find()
                    ->joinWith('userAuth')
                    ->where(['user_auth.user_token'=>$authHeader])
                    ->one();



                if($user) {
                    $authToken = UserAuth::findByApiTokenAndUserId($token->token, $user->id);

                    if($authToken){
                        $responseObj['user_token']=$authToken->user_token;
                        $responseObj['user']=$user->getUserMidi(true);
                        $isAuth=true;


                    }


                }else{

                }

                } catch (\Exception $e){



                }




            }



            $responseObj['user_authorized']=$isAuth;

            // $responseObj['min_order']=\Yii::$app->params['min_order'];
            // $responseObj['max_points']=\Yii::$app->params['max_points'];

            $responseObj['min_order'] = SiteSettings::getValuebyKey('min_order');
            $responseObj['max_points'] = SiteSettings::getValuebyKey('max_percent_of_write');

            return $this->sendResponse($responseObj);
        }
        else{
            return $this->sendError(MyError::API_TOKEN_CANT_CREATE);
        }








    }


}