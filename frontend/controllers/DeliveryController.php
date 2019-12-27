<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;

class DeliveryController extends FrontendController
{
    public function actionIndex(){

        return $this->render('index');
                
    }
}