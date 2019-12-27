<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;
use common\models\Order;
use common\models\Address;
use frontend\models\forms\UserPersonalForm;
use frontend\models\forms\UserNameForm;
use frontend\models\forms\UserPasswordForm;
use frontend\models\forms\AddressForm;
use common\models\ChangePhoneRequest;

class CabinetController extends FrontendController
{
    public function actionIndex(){

    	$orders = Order::find()->where(['user_id' => \Yii::$app->user->id])->all();
        $user = new UserPersonalForm();
        $person = $user->me();
        $user = new UserNameForm();
        $phone = $user->my();
    	$addresses = Address::find()->where(['user_id' => \Yii::$app->user->id])->all();
    	$new_address = new AddressForm();
    	$discount = null;
    	$follow = null;
    	$password = new UserPasswordForm();

        return $this->render('index',[
        	'person' => $person,
        	'phone' => $phone,
        	'addresses' => $addresses,
        	'discount' => $discount,
        	'follow' => $follow,
        	'password' => $password,
        	'orders' => $orders,
        	'new_address' => $new_address,
        ]);
                
    }

    public function actionAddaddress(){
    	$new_address = new AddressForm();
        if ($new_address->load(\Yii::$app->request->post()) && $new_address->add())
        {
            $new_address = new AddressForm();
        }
    	$addresses = Address::find()->where(['user_id' => \Yii::$app->user->id])->all();
 
        return $this->render('_address_form', [
            'addresses' => $addresses,
            'new_address' => $new_address,
        ]);
    }

    public function actionDeladdress(){
        $address_id = \Yii::$app->request->post('id');
        $address = \common\models\Address::find()->where(['user_id' => \Yii::$app->user->id, 'id' => $address_id])->one();
        if($address->delete())
            return $this->sendJSONResponse([
                'error'=>false,
            ]);
        else
            return $this->sendJSONResponse([
                'error'=>true,
            ]);
    }

    public function actionPassword(){
        
        $password = new UserPasswordForm();
        if($password->load(\Yii::$app->request->post()) && $password->change())
        {
            $password = new UserPasswordForm();
            return $this->render('_password_form', [
                'error'=>false,
                'password' => $password,
            ]);
        }
        else
            return $this->render('_password_form', [
                'error'=>true,
                'password' => $password,
            ]);
    }

    public function actionPersonal(){
        
        $user = new UserPersonalForm();
        $person = $user->me();
        $success = false;
        if ($person->load(\Yii::$app->request->post()) && $person->validate())
        {
            $success = $person->change();
        }
        return $this->render('_personal_form', [
            'person' => $person,
            'success' => $success,
        ]);
    }

    public function actionPhone(){
        
        $user = new UserNameForm();
        $phone = $user->my();
        $request = false;

        if ($phone->load(\Yii::$app->request->post()) && $phone->validate())
        {
            $request_id = $phone->change();
        }
 
        return $this->render('_phone_form', [
            'phone' => $phone,
            'request_id' => $request_id,
        ]);
    }

    public function actionConfirmphone(){

        $user = new UserNameForm();
        $phone = $user->my();

        $request_id = \Yii::$app->request->post('request_id');
        $code = \Yii::$app->request->post('code');

        if ($request_id && $code && $request = ChangePhoneRequest::findOne($request_id) ){

            if ($request->user_id == \Yii::$app->user->id && $request->validatePassword($code)){

                $user= \Yii::$app->user->getIdentity();
                $user->username = $request->new_phone;
                if ($user->save()){
                    $user = new UserNameForm();
                    $phone = $user->my();
                }
            }
        }
        return $this->render('_phone_form', [
            'phone' => $phone,
            'request_id' => false,
        ]);
    }
}