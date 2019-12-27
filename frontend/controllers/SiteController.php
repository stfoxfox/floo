<?php
namespace frontend\controllers;

use common\components\controllers\FrontendController;
use Yii;
use common\models\CatalogCategory;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\CatalogItem;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->request->getPathInfo() == 'site/index.html' || Yii::$app->request->getPathInfo() == 'site.html'){
            $this->redirect(Url::to('/'));
        }        
        // $categoryObj=CatalogCategory::find()->where(['is_main_page' => true])->one();
        $stocks=\common\models\Promo::find()->where(['active' => true])->andWhere('external_site_id is null')->all();
        // if($categoryObj)
        //     $pizza = array_slice($categoryObj->catalogItems, 0, 6);
        // else
        //     $pizza = [];
        $pizza = CatalogItem::find()->select(['catalog_item.*','catalog_category.sort'])->where(['catalog_item.is_main_page' => true])->joinWith(['category'])->orderBy('catalog_category.sort, catalog_item.sort ')->limit(24)->all();
        
        return $this->render('index',['pizza'=>$pizza, 'stocks' => $stocks]);
    }

    public function actionCallback()
    {
        $success = false;
        $callback_form = new \frontend\models\forms\CallbackForm();

        if ($callback_form->load(Yii::$app->request->post()) && $callback_form->saveCallback()) {
            $success = true;
            $callback_form = new \frontend\models\forms\CallbackForm();
        }

        return $this->render('callback', [
            'callback_form' => $callback_form,
            'success' => $success,
            'message' => 'Мы перезвоним вам в ближайшее время',
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/cabinet.html');
        } else {
            $this->layout = 'login';
            return $this->render('login', [
                'login_model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionError($message)
    {
        return $this->render('error', ['message' => $message]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $signup_model = new SignupForm();
        if ($signup_model->load(Yii::$app->request->post())) {
            if ($user = $signup_model->signup()) {
                //if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                //}
            }
        }

        $this->layout = 'login';
        return $this->render('signup', [
            'signup_model' => $signup_model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
