<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 25.08.15
 * Time: 20:34
 */

namespace common\components\MyExtensions;
use Facebook\Authentication\AccessToken;
use Facebook\Facebook;
use yii\helpers\Url;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;



class MyFacebook {


    const app_id = "906827829410244";
    const app_secret = "1a44b58f3086f2079f23e8ca88fb6c6f";

    public static function getLoginUrl(){

        $fb = new Facebook([
            'app_id' => self::app_id,
            'app_secret' => self::app_secret,
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email','user_friends']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(Url::toRoute(['site/fb-login'],true),$permissions);

        return $loginUrl;

    }


    /**
     * @param $accessToken
     * @return bool|\Facebook\GraphNodes\GraphUser
     */
    public static function getUserInfo($accessToken){

        $fb = new Facebook([
            'app_id' => self::app_id,
            'app_secret' => self::app_secret,
            'default_graph_version' => 'v2.5',
        ]);

        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=name,email,id,picture', $accessToken);
        } catch(FacebookResponseException $e) {
            /*echo 'Graph returned an error: ' . $e->getMessage();
            exit;
            */
            return false;
        } catch(FacebookSDKException $e) {
          /*  echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          */
            return false;
        }

        $user = $response->getGraphUser();


        return $user;


    }

    public static function getGetAccessToken(){

        $fb = new Facebook([
            'app_id' => self::app_id,
            'app_secret' => self::app_secret,
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(FacebookResponseException $e) {
            // When Graph returns an error

            return false;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues

            return false;
        }

        if (! isset($accessToken)) {
           /* if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }*/
           return false;
        }

// Logged in


// The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

       $user_id=$tokenMetadata->getUserId();

// Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(self::app_id);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
               return false;
            }

           // echo '<h3>Long-lived</h3>';
           // var_dump($accessToken->getValue());
        }

       // $_SESSION['fb_access_token'] = (string) $accessToken;

        return ['a_t'=>(string) $accessToken,'user_id'=>$user_id];

    }

    public static function checkTokenForAPI($access_token,$fb_user_id){

        $fb = new Facebook([
            'app_id' => self::app_id,
            'app_secret' => self::app_secret,
            //'default_graph_version' => 'v2.2',
        ]);




        $oAuth2Client = $fb->getOAuth2Client();

        $tokenMetadata = $oAuth2Client->debugToken($access_token);


        $user_id=$tokenMetadata->getUserId();

        $expires = $tokenMetadata->getExpiresAt();


        $accessToken = new AccessToken($access_token,$expires->getTimestamp());

// Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(self::app_id);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

            } catch (FacebookSDKException $e) {
                return false;
            }

            // echo '<h3>Long-lived</h3>';
            // var_dump($accessToken->getValue());
        }

        if($user_id==$fb_user_id){

            return ['a_t'=>(string) $accessToken,'user_id'=>$user_id];

        }
        else return false;





    }



}