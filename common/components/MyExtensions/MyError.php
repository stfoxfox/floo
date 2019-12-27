<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 26.08.15
 * Time: 23:20
 */

namespace common\components\MyExtensions;


class MyError {

    const BAD_REQUEST= 10000;

    const API_TOKEN_NOT_SET= 10001;
    const API_TOKEN_NOT_FIND= 10002;
    const API_TOKEN_CANT_CREATE= 10003;
    const API_TOKEN_BAD_REQUEST= 10004;


    const USER_NEED_LOGIN= 20001;
    const USER_NOT_HAVE_PERMISSION= 20002;
    const USER_FACEBOOK_ACCESS_TOKEN_ERROR= 20003;
    const USER_TWITTER_ACCESS_TOKEN_ERROR= 20004;
    const USER_GP_ACCESS_TOKEN_ERROR= 20005;
    const USER_VK_ACCESS_TOKEN_ERROR= 20006;


    const USER_REGISTRATION_FIELDS_ERROR= 30000;
    const USER_REGISTRATION_USER_NAME_TAKEN= 30001;
    const USER_REGISTRATION_EMAIL_TAKEN= 30002;
    const USER_REGISTRATION_CANT_REGISTER= 30003;


    const USER_LOGIN_NOT_FOUND_OR_WRONG_PASSWORD= 31001;



    const PROMO_FINISHED= 41001;
    const PROMO_PLEASE_RETRY= 41002;


    const TALK_NOT_FOUND= 50001;
    const TALK_USER_CANT_JOIN= 50002;

    const MESSAGE_NOT_FOUND= 51001;

    const CITY_NOT_FOUND= 60001;

    const SPOT_NOT_FOUND= 70001;
    const SPOT_HAS_NOT_CATALOG_ITEMS= 70002;


    const USER_NOT_FOUND= 80001;


    const ORDER_ALREADY_REGISTERED= 90001;
    const HAVE_NOT_COVERS= 90002;


    const YOU_CANT_GRAND_TO_YOU_SELF= 91001;


    const ONE_CHECK_IN_PER_30_MINUTES= 71001;

    public static function getMsg($code){

        $class = new \ReflectionClass(__CLASS__);
        $constants = array_flip($class->getConstants());

        return \Yii::t('app/error',$constants[$code]);
    }


    public static function sendErrorMessage($message,$email = "popov.anatoliy@gmail.com",$forGroup = null){


        \Yii::$app->mailer->compose()
            ->setFrom('webmaster@pronto24.ru')
            ->setTo($email)
            ->setTextBody($message)
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->send();

    }



}