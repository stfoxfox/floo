<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 12.11.15
 * Time: 15:56
 */

namespace common\components\MyExtensions;


use DOMDocument;
use SMSRU;
use stdClass;

class MyHelper {

    public static function searchById($array,$id){
        $return = null;

        foreach($array as $el){

            if($el->id==$id){
                $return = $el;
                break;
            }
        }


        return $return;
    }


    public static function sendMessage($message,$subject="Письмо с сайта",$email = "popov.anatoliy@gmail.com",$forGroup = null){


        \Yii::$app->mailer->compose()
            ->setFrom('webmaster@pronto24.ru')
            ->setTo($email)
            ->setTextBody($message)
            ->setSubject($subject)
            ->send();

    }


    public static function array2xml($data, $rootNodeName = 'data', $xml = null)
    {
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }



        foreach ($data as $key => $value) {
            $key = preg_replace('/[^a-z\_]/i', '', $key);

            if (empty($key)) {
                $key = 'item';
            }

            if (is_array($value) && $key != 'attributes') {
                $node = $xml->addChild($key);
                self::array2xml($value, $rootNodeName, $node);
            } else if (is_array($value)) {
                foreach ($value as $attribute_key => $attribute_value) {
                    $xml->addAttribute($attribute_key, $attribute_value);
                }
            } else {
                $xml->addChild($key, $value);
            }
        }

        $doc = new DOMDocument('1.0');
        $doc->preserveWhiteSpace = false;
        $doc->loadXML($xml->asXML());
        $doc->formatOutput = true;

        return $doc->saveXML();
    }


    public static function generateXml($action, $name, $data, $appendFileName=true) {
        if ($appendFileName) {
            if (isset($data['attributes']['id'])) {
                $name .= '_' . $data['attributes']['id'];
            } else {
                $c = 0;
                do {
                    $c++;
                } while(file_exists(\Yii::getAlias('@for_jupiter'. '/') . $name . '_' .$c . '.xml'));
                $name = $name . '_' . $c;
            }
        }

        $rootNodeName = 'service action="' . $action . '"';

        $fp = fopen(MyFileSystem::makeDirs(\Yii::getAlias('@for_jupiter'. '/'). $name . '.xml'), 'w');
        fputs($fp, self::array2xml($data, $rootNodeName));
        fclose($fp);
        chmod(\Yii::getAlias('@for_jupiter'. '/'). $name . '.xml',0777);
    }



    public static  function sendSms($text,$phone){

        require_once 'sms.ru.php';


        $smsru = new SMSRU('CE7DBE3B-340C-D85A-0E32-87ECEE78D9EF'); // Ваш уникальный программный ключ, который можно получить на главной странице

        $data = new stdClass();
        $data->to = $phone;
        $data->text = $text; // Текст сообщения
// $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
// $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
// $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
// $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
// $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
        $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную




    return [];



    }


    public static function preparePhone($phone){

        $numeric_filtered = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

        $numeric_filtered = str_replace("+","",$numeric_filtered);
        $numeric_filtered = str_replace("-","",$numeric_filtered);
        if (strlen($numeric_filtered) != 10){
            while (strlen($numeric_filtered) != 10){

                $numeric_filtered = substr($numeric_filtered, 1);
            }
            return $numeric_filtered;

        }else {
            
        }
        return $numeric_filtered; // Will print "3,373.31"



    }

    public static function formatTextToHTML($string,$useBr=false){
        $strGlue =($useBr)?"<br>":"</p><p>";
        $pArray = preg_split('/\n|\r\n/', $string);
        $returnStr = implode($strGlue,$pArray);

        if (!$useBr){
            $returnStr = "<p>".$returnStr."</p>";
        }

        return  $returnStr;
    }

}