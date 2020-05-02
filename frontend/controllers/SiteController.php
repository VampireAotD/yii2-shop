<?php

namespace frontend\controllers;

use frontend\components\AuthHandler;
use frontend\models\Slide;
use frontend\models\Categories;
use frontend\models\Goods;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

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
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Render index view
     * @return string
     */
    public function actionIndex()
    {
        $categories_model = new Categories;
        $goods_model = new Goods;
        $slider_model = new Slide;

        $goods = $goods_model->getGoodsList();

        $pagination = new Pagination([
            'pageSize' => 20,
            'totalCount' => $goods->count()
        ]);

        $categories = $categories_model->getCategoriesList();
        $goods = $goods->offset($pagination->offset)->limit($pagination->limit)->cache(Yii::$app->params['defaultCookieTime'])->all();
        $slides = $slider_model->getSlideList();
        $max_price = Goods::getMaxPrice();
        $currency = Yii::$app->cookiesAndSession->getCookieValue('currency');

        return $this->render('index', compact('categories', 'goods', 'pagination', 'slides', 'max_price', 'currency'));
    }

    public function actionSearch()
    {
        $categories_model = new Categories;
        $goods_model = new Goods;
        $slider_model = new Slide;

        $params = [];
        if (Yii::$app->request->get()) {
            $params = Yii::$app->request->get();
        }

        $goods = $goods_model->search($params);

        $pagination = new Pagination([
            'pageSize' => 20,
            'totalCount' => $goods->count()
        ]);

        $categories = $categories_model->getCategoriesList();
        $goods = $goods->offset($pagination->offset)->limit($pagination->limit)->all();
        $slides = $slider_model->getSlideList();
        $max_price = Goods::getMaxPrice();

        return $this->render('index', compact('categories', 'goods', 'pagination', 'slides', 'max_price'));
    }

    public function actionSetCurrency()
    {
        $currency = Yii::$app->request->get('currency');
        Yii::$app->cookiesAndSession->createNewCookie('currency', $currency);
        return $this->redirect(Yii::$app->request->referrer);
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
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
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

    public function actionLanguage()
    {
        if (Yii::$app->request->post('language')) {
            Yii::$app->language = Yii::$app->request->post('language');
            Yii::$app->cookiesAndSession->createNewCookie('language', Yii::$app->request->post('language'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('mail', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('mail', 'There was an error sending your message.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }


    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t('mail', 'Thank you for registration. Please check your inbox for verification email.'));
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
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
                Yii::$app->session->setFlash('success', Yii::t('mail', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('mail', 'Sorry, we are unable to reset password for the provided email address.'));
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
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('mail', 'New password saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', Yii::t('mail', 'Your email has been confirmed!'));
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', Yii::t('mail', 'Sorry, we are unable to verify your account with provided token.'));
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('mail', 'Check your email for further instructions.'));
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', Yii::t('mail', 'Sorry, we are unable to resend verification email for the provided email address.'));
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
