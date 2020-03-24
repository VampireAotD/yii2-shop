<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\widgets\Alert;
use frontend\widgets\SearchWidget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use frontend\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?php
        $this->registerJsFile('js/html5shiv.js', ['condition' => 'lte IE 9', 'position' => \yii\web\View::POS_HEAD]);
        $this->registerJsFile('js/respond.min.js', ['condition' => 'lte IE 9', 'position' => \yii\web\View::POS_HEAD]);
        ?>
    </head><!--/head-->

    <body>
    <?php $this->beginBody() ?>
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-envelope"></i> ilya10@ukr.net</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-vk"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="<?= Yii::$app->homeUrl ?>"><img src="/uploads/static/home/logo.png" alt=""/></a>
                        </div>
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <?php
                                echo Html::beginForm('/site/language', 'post', ['class' => 'language-form']);
                                echo Html::dropDownList(
                                    'language',
                                    Yii::$app->language,
                                    ['en-EN' => 'English', 'ru-RU' => 'Русский'],
                                    ['class' => 'language-selection']
                                );
                                Html::endForm();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= Url::to(['/wishlist/default/index']) ?>" class="wishlist"><i
                                                class="fa fa-heart"></i> <?= Yii::t('main', 'Wishlist') ?>
                                        <span>
                                            <?php
                                            if (!empty(Yii::$app->cookiesAndSession->countElementOfCookieValue('wishlist'))) {
                                                echo "(" . Yii::$app->cookiesAndSession->countElementOfCookieValue('wishlist') . ")";
                                            }
                                            ?>
                                        </span>
                                    </a>
                                </li>
                                <li><a href="<?= Url::to(['/cart/default/index']) ?>" class="cart"><i
                                                class="fa fa-shopping-cart"></i> <?= Yii::t('main', 'Cart') ?>
                                        <span>
                                            <?php
                                            if (!empty(Yii::$app->cookiesAndSession->countSessionElements('basket'))) {
                                                echo "(" . Yii::$app->cookiesAndSession->countSessionElements('basket') . ")";
                                            }
                                            ?>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="mainmenu pull-left">
                            <?php
                            $menuItems = [
                                ['label' => Yii::t('main', 'Home'), 'url' => ['/site/index']],
                                ['label' => Yii::t('main', 'Contact'), 'url' => ['/site/contact']],
                            ];
                            if (Yii::$app->user->isGuest) {
                                $menuItems[] = ['label' => Yii::t('main', 'Signup'), 'url' => ['/site/signup']];
                                $menuItems[] = ['label' => Yii::t('main', 'Login'), 'url' => ['/site/login']];
                            } else {
                                $menuItems[] = ['label' => Yii::t('main', 'Logout ({username})', ['username' => Yii::$app->user->identity->username]),
                                    'url' => ['/site/logout'],
                                    'linkOptions' => ['data-method' => 'post']];
                            }
                            echo Nav::widget([
                                'options' => ['class' => 'nav navbar-nav collapse navbar-collapse'],
                                'items' => $menuItems,
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="search_box pull-right">
                            <?php
                            ActiveForm::begin([
                                'action' => '/site/index',
                                'method' => 'GET'
                            ]);
                            echo SearchWidget::widget();
                            ActiveForm::end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-bottom-->
    </header><!--/header-->

    <div class="container">
        <div class="breadcrumbs">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

    <footer id="footer"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p><?= Yii::t('main', 'Internet shop made with {framework}', ['framework' => 'Yii2']) ?></p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="/uploads/static/home/map.png" alt=""/>
                            <p class="text-center col-sm-12"><?= Yii::t('main', 'Kiev,Ukraine') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Made by <span><a target="_blank" href="https://github.com/VampireAotD"> Stepenko </a></span>&copy;<?= date('Y') ?>
                    </p>
                    <p class="pull-right"></p>
                </div>
            </div>
        </div>

    </footer><!--/Footer-->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>