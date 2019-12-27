<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 09.09.15
 * Time: 15:26
 */

namespace common\components\MyExtensions;


use Abraham\TwitterOAuth\TwitterOAuth;

class MyTwitter {



    public static function checkUser($accessToken,$accessTokenSecret,$userId){

        $connection = new TwitterOAuth("GTyx6oL0CfEfwrLdGg172gpSs", "xtoSyUJKk7qHXNptXlPrsT1m7rcPoGBVS1wAystjGMgqFcY5cb", $accessToken, $accessTokenSecret);
        $content = $connection->get("account/verify_credentials");

        
        if($content && $content->id && $content->id == $userId)
            return true;
        else
            return false;

    }
}