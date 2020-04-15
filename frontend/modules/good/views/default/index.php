<?php
/**
 * @var $this \yii\web\View
 * @var $good \frontend\models\Goods
 * @var $subscribeModel \frontend\models\Subscription
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $good->name;
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $good->meta_keywords ? $good->meta_keywords : $this->title
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $good->meta_description ? $good->meta_description : $this->title
]);
$this->registerMetaTag([
    'name' => 'title',
    'content' => $good->meta_title ? $good->meta_title : $this->title
]);
?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product">
                                <img src="<?= $good->getImage() ?>" alt=""/>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="product-information"><!--/product-information-->
                                <h2><?= $good->name ?></h2>
                                <p><b><?= Yii::t('good', 'Availability') ?>:</b>
                                    <?php
                                    if ($good->amount > 0) {
                                        echo Yii::t('good', 'In stock');
                                    } else {
                                        echo Yii::t('good', 'Not in stock');
                                    }
                                    ?>
                                </p>
                                <p><b><?= Yii::t('good', 'Description') ?>:</b> <?= $good->getDescription() ?></p>
                                <p><b><?= Yii::t('good', 'Date') ?>
                                        :</b> <?= Yii::$app->formatter->asDate($good->date) ?></p>
                                <p><b><?= Yii::t('index', 'Categories') ?>:</b>
                                    <?php
                                    foreach ($good->getCategories() as $id => $name) {
                                        echo Html::a($name, ['/site/index', 'id_cat' => $id]) . '&nbsp;';
                                    }
                                    ?>
                                </p>
                                <span>
									<span><?= Yii::$app->formatter->asCurrency($good->price) ?></span>
                                    <?php if ($good->amount > 0) { ?>
                                        <?php
                                        if (!Yii::$app->cookiesAndSession->inSession('basket', $good->id)) {
                                            ?>
                                            <a href="<?= Url::to(['/cart/default/add', 'id' => $good->id]) ?>"
                                               class="btn btn-default add-to-cart"><i
                                                        class="fa fa-shopping-cart"></i><?= Yii::t('index', 'Add to cart') ?>
                                                        </a>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="btn btn-default already-in-cart"><i
                                                        class="fa fa-shopping-cart"></i> <?= Yii::t('index', 'In cart') ?>
                                                        </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } else {
                                        $form = ActiveForm::begin(['method' => 'post', 'action' => Url::to(['subscribe']), 'options' => ['class' => 'subscribe-form']]);
                                        echo $form->field($subscribeModel, 'email')->label(Yii::t('good', 'Subscribe to mailing'));
                                        echo $form->field($subscribeModel, 'id_good')->input('hidden', ['value' => $good->id])->label(false)->error(false);
                                        echo Html::submitButton(Yii::t('good', 'Subscribe'), ['class' => 'btn btn-default']);
                                        ActiveForm::end();
                                    }
                                    ?>
								</span>
                            </div><!--/product-information-->
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#comments"
                                                      data-toggle="tab"><?= Yii::t('good', 'Comments') ?></a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="comments">
                                <div class="col-sm-12">
                                    <?php echo \yii2mod\comments\widgets\Comment::widget([
                                        'model' => $good,
                                        'commentView' => '@frontend/modules/good/views/comments/index',
                                        'dataProviderConfig' => [
                                            'pagination' => [
                                                'pageSize' => 50
                                            ],
                                        ],
                                        'listViewConfig' => [
                                            'emptyText' => Yii::t('good', 'No comments found'),
                                        ],
                                    ]); ?>
                                </div>
                            </div>

                        </div>
                    </div><!--/category-tab-->

                    <?php if ($similarGoods) : ?>
                        <div class="recommended_items"><!--recommended_items-->
                            <h2 class="title text-center"><?= Yii::t('good', 'Similar') ?></h2>

                            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <!-- Slides -->
                                        <?php foreach ($similarGoods as $similarGood) : ?>
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <img src="<?= Yii::$app->storage->getFile($similarGood['image']) ?>"
                                                                 alt=""/>
                                                            <h2><?= Yii::$app->formatter->asCurrency($similarGood['price']) ?></h2>
                                                            <p><?= $similarGood['name'] ?></p>
                                                            <?= Html::a('<i class="fa fa-shopping-cart"></i>' . Yii::t('index', 'Details') . '', ['/good/default/index', 'id' => $similarGood['id']], ['class' => 'btn btn-default']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                        </div><!--/recommended_items-->
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </section>
<?php
$this->registerJsFile('js/add-to-cart.js', ['depends' => \yii\web\JqueryAsset::class]);