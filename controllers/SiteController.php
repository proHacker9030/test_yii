<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
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
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/user']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionActivate($hash)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($hash) {
            $user = User::findOne(['activation_code' => $hash]);
            if(!$user)
            {
                $message = "Данная ссылка уже была использована";
                return $this->render('error',compact('message'));
            }
            $rememberMe = true;
            $user->activation_code = 'activated';
            $user->update();
            Yii::$app->session->setFlash('activationSuccess','Вы успешно активировали свой профиль.');
            Yii::$app->user->login($user, $rememberMe ? 60 : 0);
            return $this->redirect(['/user']);
        } else {
            $message = "Ошибка активации";
            return $this->render('error',compact('message'));
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRegister()
    {
        $model = new User();

        if (Yii::$app->request->post()) {
            $model->activation_code = Yii::$app->getSecurity()->generateRandomString();
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($_POST['User']['password']);
            $model->usersurname = $_POST['User']['usersurname'];
            $model->username = $_POST['User']['username'];
            $model->email = $_POST['User']['email'];
            if ($model->save()) {
                return $this->render('confirm', compact('model'));
            }
        }

        return $this->render('register', compact('model'));
    }
}
