<?php
/**
 * @var $goods \frontend\models\Goods
 */

use frontend\widgets\buttons\ButtonsWidget;

foreach ($goods as $recommended) : ?>
    <div class="col-sm-3">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <img src="<?= $recommended->getImage() ?>" alt=""/>
                    <h2>
                        <?php if ($currency) : ?>
                            <?= $currency . ' ' . Yii::$app->currencyHelper->getPrice($currency, $recommended->price) ?>
                        <?php else: ?>
                            <?= Yii::$app->formatter->asCurrency($recommended->price) ?>
                        <?php endif; ?>
                    </h2>
                    <p>
                        <a href="<?= \yii\helpers\Url::to(['good/default/index', 'id' => $recommended->id]) ?>"><?= $recommended->name ?></a>
                    </p>
                    <?= ButtonsWidget::widget(['id' => $recommended->id]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>