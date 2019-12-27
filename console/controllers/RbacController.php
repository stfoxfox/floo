<?php
namespace console\controllers;

use backend\models\BackendUser;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {

        $adminUser= new BackendUser();

        $adminUser->username = "prontoAdmin";
        $adminUser->email = "admin@pronto24.ru";
        $adminUser->setPassword("123123123");
        $adminUser->generateAuthKey();
        if ($adminUser->save()) {
            $auth = Yii::$app->authManager;


            // add "admin" role and give this role the "updatePost" permission
            // as well as the permissions of the "author" role
            $admin = $auth->createRole('admin');
            $auth->add($admin);


            // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
            // usually implemented in your User model.
            $auth->assign($admin, $adminUser->id);
        }
        else
            print_r($adminUser->getErrors());

    }



    public function actionCreateContentRole(){

        $auth = Yii::$app->authManager;


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('content_manager');
        $auth->add($admin);

    }

}