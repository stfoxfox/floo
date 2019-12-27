<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 27.08.15
 * Time: 0:29
 */
namespace common\components\filters;



use common\components\MyExtensions\MyError;
use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessRule;

class ApiAccessControl extends ActionFilter {


    /**
     * @var User|array|string the user object representing the authentication status or the ID of the user application component.
     * Starting from version 2.0.2, this can also be a configuration array for creating the object.
     */
    public $user = 'user';


    public $checkApiToken=true;

    public $rules = [];

    public $ruleConfig = ['class' => 'yii\filters\AccessRule'];

    public $denyCallback;
    /**
     * Initializes the [[rules]] array by instantiating rule objects from configurations.
     */
    public function init()
    {
        parent::init();
        $this->user = Instance::ensure($this->user, User::className());
        foreach ($this->rules as $i => $rule) {
            if (is_array($rule)) {
                $this->rules[$i] = Yii::createObject(array_merge($this->ruleConfig, $rule));
            }
        }
    }

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {

        $user = $this->user;
        $request = Yii::$app->getRequest();
        /* @var $rule AccessRule */
        foreach ($this->rules as $rule) {
            if ($allow = $rule->allows($action, $user, $request)) {
                return true;
            } elseif ($allow === false) {
                if (isset($rule->denyCallback)) {
                    call_user_func($rule->denyCallback, $rule, $action);
                } elseif (isset($this->denyCallback)) {
                    call_user_func($this->denyCallback, $rule, $action);
                } else {
                    $this->denyAccess($user);
                }
                return false;
            }
        }

        if (isset($this->denyCallback)) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess($user);
        }
        return false;
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            echo json_encode(['error_code'=>MyError::USER_NEED_LOGIN,'error_msg'=>MyError::getMsg(MyError::USER_NEED_LOGIN)]);
            Yii::$app->response->send();

        } else {
            echo json_encode(['error_code'=>MyError::USER_NOT_HAVE_PERMISSION,'error_msg'=>MyError::getMsg(MyError::USER_NOT_HAVE_PERMISSION)]);
            Yii::$app->response->send();
        }
    }

    protected function denyApiAccess(){

       echo json_encode(['error_code'=>MyError::API_TOKEN_NOT_SET,'error_msg'=>MyError::getMsg(MyError::API_TOKEN_NOT_SET)]);
        Yii::$app->response->send();
    }


}