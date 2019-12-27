<?php

namespace frontend\controllers;

use common\components\controllers\FrontendController;

class BanquetController extends FrontendController
{
    public function actionIndex(){

        return $this->render('index');
                
    }
}