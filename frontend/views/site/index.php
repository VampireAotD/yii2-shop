<?php

/**
 * @var $this yii\web\View
 * @var $categories \frontend\models\Categories
 * @var $goods \frontend\models\Goods
 * @var $slides \frontend\models\Slide
 * @var $currency string
 * @var $max_price double
 */

use frontend\widgets\buttons\ButtonsWidget;
use frontend\widgets\PriceRangeWidget;
use frontend\widgets\recent\RecentViewedWidget;
use frontend\widgets\recommentdations\RecommendationsList;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Yii shop';
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title
]);
$this->registerMetaTag([
    'name' => 'title',
    'content' => $this->title
]);

?>
    <?php if (count($slides) > 0) : ?>
        <section id="slider"><!--slider-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="promo-slider">
                            <?php foreach ($slides as $slide) : ?>
                                <a href="<?= Url::to(['/good/default/index', 'id' => $slide->id_good]) ?>">
                                    <div class="slider-image"
                                         style="background: url('<?= $slide->getImage() ?>') center center; -webkit-background-size: cover; background-size: cover;">
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </section><!--/slider-->
    <?php endif; ?>

    <div style="height: 40px;"></div><!--clearfix-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2><?= Yii::t('index', 'Categories') ?></h2>
                        <div class="panel-group category-products" id="accordian"><!--category-products-->
                            <?php foreach ($categories as $category) : ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a
                                                    href="<?= Url::to(['/site/index', 'id_cat' => $category->id], true) ?>"><?= $category->name ?></a>
                                        </h4>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="<?= Url::to(['/site/index']) ?>">Все товары</a>
                                    </h4>
                                </div>
                            </div>
                        </div><!--/category-products-->

                        <div class="price-range"><!--price-range-->
                            <h2><?= Yii::t('index', 'Price Range') ?></h2>
                            <div class="well text-center">
                                <?php
                                ActiveForm::begin([
                                    'action' => '/site/search',
                                    'method' => 'GET',
                                ]);
                                echo PriceRangeWidget::widget();
                                ?>
                                <b class="pull-left">$ 0</b> <b class="pull-right">$ <?= $max_price ?></b>
                                <input type="text" name="price-search" class="price-change" style="display: none;">
                                <input type="submit" name="price" class="price-find"
                                       value="<?= Yii::t('index', 'Price Range') ?>">
                                <?php
                                ActiveForm::end();
                                ?>
                            </div>
                        </div><!--/price-range-->

                    </div>
                </div>

                <div class="col-sm-9 padding-right">
                    <?php
                    Pjax::begin(['timeout' => 5000])
                    ?>
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center"><?= Yii::t('index', 'Features Items') ?></h2>
                        <?php
                        if ($goods) {
                            ?>
                            <?php foreach ($goods as $good) : ?>
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="<?= $good->getImage() ?>" alt=""/>
                                                <h2>
                                                    <?php if ($currency) : ?>
                                                        <?= $currency . ' ' . Yii::$app->currencyHelper->getPrice($currency, $good->price) ?>
                                                    <?php else: ?>
                                                        <?= Yii::$app->formatter->asCurrency($good->price) ?>
                                                    <?php endif; ?>
                                                </h2>
                                                <p><?= $good->name ?></p>
                                            </div>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                    <h2><?= $good->name ?></h2>
                                                    <?= ButtonsWidget::widget(['id' => $good->id]) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="choose">
                                            <ul class="nav nav-pills nav-justified controls">
                                                <li>
                                                    <a href="<?= Url::to(['/good/default/index', 'id' => $good->id]) ?>"><i
                                                                class="fa fa-info-circle"></i><?= Yii::t('index', 'Details') ?>
                                                    </a></li>
                                                <?php
                                                if (!Yii::$app->cookiesAndSession->inCookiesValue('wishlist', $good->id)) {
                                                    ?>
                                                    <li>
                                                        <a href="<?= Url::to(['/wishlist/default/add', 'id' => $good->id]) ?>"
                                                           class="add-to-wishlist" data-id="<?= $good->id ?>"><i
                                                                    class="fa fa-heart"></i><?= Yii::t('index', 'Add to wishlist') ?>
                                                        </a></li>
                                                    <?php
                                                } else { ?>
                                                    <li>
                                                        <a href="<?= Url::to(['/wishlist/default/delete', 'id' => $good->id]) ?>"
                                                           class="remove-from-wishlist" data-id="<?= $good->id ?>"><i
                                                                    class="fa fa-heart"></i><?= Yii::t('index', 'Remove from wishlist') ?>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php
                        } else {
                            echo Html::tag('div', 'No results', ['class' => 'product-image-wrapper']);
                        }
                        ?>
                    </div><!--features_items-->

                    <?php
                    Pjax::end();
                    ?>

                    <div style="height: 50px">
                        <?= LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>

                    <div class="category-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#recent"
                                                      data-toggle="tab"><?= Yii::t('index', 'Recent') ?></a></li>
                                <li><a href="#popular" data-toggle="tab"><?= Yii::t('index', 'Popular') ?></a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="recent">
                                <?= RecommendationsList::widget() ?>
                            </div>

                            <div class="tab-pane fade" id="popular">
                                <?= RecommendationsList::widget(['criteria' => 'views DESC']) ?>
                            </div>
                        </div>
                    </div><!--/category-tab-->

                    <?= RecentViewedWidget::widget() ?>

                </div>
            </div>
        </div>
    </section>

<?php
$this->registerJsFile('js/add-to-wishlist.js', ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile('js/add-to-cart.js', ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile('js/swiper.js', ['depends' => \frontend\assets\AppAsset::class]);
$this->registerJsFile('js/slider.js', ['depends' => \frontend\assets\AppAsset::class]);