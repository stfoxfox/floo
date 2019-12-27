<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 18/10/2017
 * Time: 11:40
 */

namespace console\controllers;


use common\models\ExternalSite;
use yii\console\Controller;

class SiteController extends Controller
{


    public function actionAdd($url,$site_name=null){




        if (!isset($site_name)){
            $site_name= $url;
        }

        $item = new ExternalSite();
        $item->url=$url;
        $item->title=$site_name;

        $item->save();

    }

}