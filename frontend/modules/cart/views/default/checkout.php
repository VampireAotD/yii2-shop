<?php
/**
 * @var $this \yii\web\View
 * @var $items \frontend\models\Goods
 * @var $model \frontend\modules\cart\models\forms\Checkout
 * @var $user \frontend\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('forms', 'Checkout');
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Корзина,Yii shop'
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

    <section id="cart_items">
        <div class="container">
            <?php
            $form = ActiveForm::begin(['action' => '/cart/default/checkout-confirm', 'method' => 'POST']);
            ?>
            <?php
            echo $form->field($model, 'username')->input('text', ['value' => $model->getUser()->username]);
            echo $form->field($model, 'email')->input('text', ['value' => $model->getUser()->email]);
            echo $form->field($model, 'description')->textarea(['placeholder' => Yii::t('forms', 'Description')]);
            ?>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image"><?= Yii::t('table', 'Item') ?></td>
                        <td class="description"></td>
                        <td class="price"><?= Yii::t('table', 'Price') ?></td>
                        <td class="quantity"><?= Yii::t('table', 'Quantity') ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($model->getSession()) { ?>

                        <?php foreach ($model->getSession() as $item) : ?>
                            <tr>
                                <td class="cart_product">
                                    <a href="<?= Url::to(['/good/default/index', 'id' => $item['id']]) ?>"><img
                                                src="<?= Yii::$app->storage->getFile($item['image']) ?>"
                                                alt="<?= $item['name'] ?>"
                                                width="120px"></a>
                                </td>
                                <td class="cart_description">
                                    <h4>
                                        <a href="<?= Url::to(['/good/default/index', 'id' => $item['id']]) ?>"><?= $item['name'] ?></a>
                                    </h4>
                                </td>
                                <td class="cart_price">
                                    <p><?= Yii::$app->formatter->asCurrency($item['price']) ?></p>
                                </td>
                                <td class="cart_quantity">
                                    <h4>
                                        <?= $item['amount'] ?>
                                    </h4>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    <tr>
                        <td colspan="12" class="cart_total_price"><?= Yii::t('table', 'Total price') ?>
                            : <?= Html::tag('span', Yii::$app->formatter->asCurrency($total), ['class' => 'total']) ?></td>
                    </tr>
                    </tbody>
                </table>
                <input type="submit" name="Checkout"
                       value="<?= Yii::t('table', 'Checkout') ?>">
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
    </section> <!--/#cart_items-->

<?php
$this->registerJsFile('js/cart.js', ['depends' => \yii\web\JqueryAsset::class]);
