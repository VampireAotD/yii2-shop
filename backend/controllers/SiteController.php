<?php

namespace backend\controllers;

use backend\models\Orders;
use backend\models\User;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        $countOrders = Orders::find()->where(['=', $this->count('date'), Yii::$app->formatter->asDate(time(), 'd MMM Y')])->orderBy('date DESC')->count();
        $countUsers = User::find()->where(['=', $this->count('created_at'), Yii::$app->formatter->asDate(time(), 'd MMM Y')])->orderBy('created_at DESC')->count();
        return $this->render('index', compact('countOrders', 'countUsers'));
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->goBack();
            } else {
                Yii::$app->session->setFlash('danger', 'You dont have permission to be here!');
                return $this->goHome();
            }
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    protected function count($criteria)
    {
        return new Expression("DATE_FORMAT(FROM_UNIXTIME(`" . $criteria . "`), '%e %b %Y')");
    }
}
