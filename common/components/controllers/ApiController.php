<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 26.08.15
 * Time: 23:08
 */

namespace common\components\controllers;


use common\components\filters\ApiAccessControl;
use common\components\MyExtensions\MyError;
use common\models\ApiToken;
use \yii\rest\Controller;
use \yii\web\Response;
use Yii;
use common\models\User;
use common\models\UserAuth;

class ApiController extends Controller {

    /** @var  ApiToken  $api_token */
    public $api_token;


    public $user_token;

    public function init() {
        parent::init();

        Yii::$app->user->enableSession = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->setApiClient();
        $this->setUser();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' =>ApiAccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],

            ],


        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [

        ];
    }

    public static function modifyHashResponse(array $response)
    {
        $data = [];

        for ($i = 0; $i < count($response); $i += 2) {
            $data[$response[$i]] = $response[$i + 1];
        }
        return $data;
    }

    
    public function sendSuccess($code=true){



        return $this->sendResponse(['success'=>$code]);
    }

    public function sendError($code = MyError::BAD_REQUEST){

        return $this->sendResponse(['error_code'=>$code,'error_msg'=>MyError::getMsg($code)]);
    }

    public  function  sendResponse($data,$httpStatus=200){



        \Yii::$app->response->format = 'json';
        \Yii::$app->response->statusCode =$httpStatus;

        return $this->serializeData($data);

    }

    private function setApiClient(){

        $api_token=  \Yii::$app->request->getHeaders()->get('x-pronto-apitoken');




        if ( is_null( $api_token ) ) {

            echo json_encode(['error_code'=>MyError::API_TOKEN_NOT_SET,'error_msg'=>MyError::getMsg(MyError::API_TOKEN_NOT_SET)]);
            Yii::$app->response->send();
            return false;
        }

        /** @var ApiToken $token */
        $token = ApiToken::find()->where(['token'=>$api_token])->one();


        if($token){

            $this->api_token=$token;


            return true;

        }
        else
        {

        //$geo_info = geoip_record_by_name('46.34.136.237');

            echo json_encode(['error_code'=>MyError::API_TOKEN_NOT_FIND,'error_msg'=>MyError::getMsg(MyError::API_TOKEN_NOT_SET)]);
            Yii::$app->response->send();
            return false;

        }




    }


    private function setUser(){

        $authHeader = \Yii::$app->request->getHeaders()->get('x-pronto-authorization');

/// wd5pYBdXudCUS2xHKb5qk7Rk4x7-5H-j_P4VNSgsHArCgSOTF3VExb-jENZojkyhkB8XBl_eSrEaWB5ZnE79x1kfIgWYhQ1gQ8sH0nWxlz-ZAtVFuk9ze4tJeI-ZW3Z2_LWivch7WqLkO3kD4CoKleJZj2MJrK7PYKde_X3-2H2r-9HTtrOsGDNa6hW8DFqPqsmogqOmyCPoKib2lHt-36EQkmJZzei5QxdEA6gxVXjB5nGUo8SnsuKHblQu47V
        if($authHeader){

            /** @var User $user */
           $user = User::find()
            ->joinWith('userAuth')
                ->where(['user_auth.user_token'=>$authHeader])
                ->one();




            if($user) {
                $this->user_token  = $authHeader;
                Yii::$app->user->login($user);
            }




        }







    }
}