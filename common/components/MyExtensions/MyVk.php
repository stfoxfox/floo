<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 19.10.15
 * Time: 1:13
 */

namespace common\components\MyExtensions;


class MyVk
{

    var $api_secret;
    var $app_id;
    var $api_url;
    var $access_token;


    public static function checkUser($accessToken,$user_id){


        $api_id = 5111950; // Insert here id of your application
        $secret_key = 'Jsj6FPXrCcmuN52DqspQ'; // Insert here secret key of your application

        $VK = new MyVk($api_id, $secret_key);

        $resp = $VK->check($accessToken);

        if(isset($resp['response'])) {

            $respObj = $resp['response'];
            if (isset($respObj['success']) && $respObj['success']) {

                if ($respObj['user_id'] == $user_id)
                    return true;
                else
                    return false;
            }
        }


            return false;



    }


  function __construct($app_id, $api_secret, $api_url = 'api.vk.com') {
        $this->app_id = $app_id;
        $this->api_secret = $api_secret;

        if (!strstr($api_url, 'https://')) $api_url = 'https://'.$api_url;
        $this->api_url = $api_url;

      $res = file_get_contents("https://oauth.vk.com/access_token?client_id={$app_id}&client_secret={$api_secret}&v=5.37&grant_type=client_credentials");
      $accessToken= json_decode($res, true);
      $this->access_token = $accessToken['access_token'];



    }

    private  function check($access_token){

        $url = "https://api.vk.com/method/secure.checkToken?access_token={$this->access_token}&client_secret={$this->api_secret}&token={$access_token}&v=5.37";

        $res = file_get_contents($url);
        return json_decode($res, true);

    }

    function api($method,$params=false) {
        if (!$params) $params = array();
        $params['api_id'] = $this->app_id;
        $params['v'] = '5.37';
        $params['method'] = $method;
        $params['timestamp'] = time();
        $params['format'] = 'json';
        $params['random'] = rand(0,10000);
        ksort($params);
        $sig = '';
        foreach($params as $k=>$v) {
            $sig .= $k.'='.$v;
        }
        $sig .= $this->api_secret;
        $params['sig'] = md5($sig);
        $query = $this->api_url.'?'.$this->params($params);
        echo $query;
        exit;
        $res = file_get_contents($query);
        return json_decode($res, true);
    }

    function params($params) {
        $pice = array();
        foreach($params as $k=>$v) {
            $pice[] = $k.'='.urlencode($v);
        }
        return implode('&',$pice);
    }

}