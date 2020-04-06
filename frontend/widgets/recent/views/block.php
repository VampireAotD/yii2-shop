<?php
/**
 * @var $goods \frontend\models\RecentViews
 */

use frontend\widgets\buttons\ButtonsWidget;

if ($goods) {
    ?>
    <div class="recommended_items"><!--viewed_items-->

        <h2 class="title text-center"><?= Yii::t('index', 'Viewed items') ?></h2>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php foreach ($goods as $good) : ?>
                    <div class="col-sm-4 swiper-slide">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="<?= Yii::$app->storage->getFile($good['image']) ?>" alt=""/>
                                    <h2><?= Yii::$app->formatter->asCurrency($good['price']) ?></h2>
                                    <p><a href="<?=\yii\helpers\Url::to(['good/default/index', 'id' => $good->id])?>"><?= $good['name'] ?></a></p>
                                    <?php
                                    if ($good['amount'] > 0) {
                                        echo ButtonsWidget::widget(['id' => $good['id']]);
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
    </div><!--/viewed_items-->

    <?php
}

