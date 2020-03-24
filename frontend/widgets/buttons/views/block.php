<?php
use yii\helpers\Url;

if (!Yii::$app->cookiesAndSession->inSession('basket', $id)) {
    ?>
    <a href="<?= Url::to(['/cart/default/add', 'id' => $id]) ?>"
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