<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19.10.15
 * Time: 0:43
 */

namespace common\components\MyExtensions;


use Google_Client;
use Google_Service_Plus;

class MyGooglePlus
{
    const CLIENT_ID = 'YOUR_CLIENT_ID';

    /**
     * Replace this with the client secret you got from the Google APIs console.
     */
    const CLIENT_SECRET = 'YOUR_CLIENT_SECRET';

    /**
     * Optionally replace this with your application's name.
     */
    const APPLICATION_NAME = "Ermioni";


    public static function checkUser($accessToken,$user_id){



        $client = new Google_Client();
        $client->setApplicationName(MyGooglePlus::APPLICATION_NAME);
        $client->setClientId(MyGooglePlus::CLIENT_ID);
        $client->setClientSecret(MyGooglePlus::CLIENT_SECRET);


        /** @var Google_Service_Plus $plus */
        $plus = new Google_Service_Plus($client);

        $client->setAccessToken($accessToken);

        if ($client->getAccessToken())
        {
            $userinfo = $plus->userinfo;

            if($userinfo['id']==$user_id)
                return true;
            else
                return false;

        }
        else
            return false;


    }

}