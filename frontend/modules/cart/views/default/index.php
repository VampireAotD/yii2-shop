<?php
/**
 * @var $this \yii\web\View
 * @var $items \frontend\models\Goods
 * @var $model \frontend\modules\cart\models\CartHandler
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('table', 'Cart');
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
            <?php if ($items) { ?>
                <div class="table-responsive cart_info">
                    <?php
                    $form = ActiveForm::begin(['action' => '/cart/default/checkout', 'method' => 'POST']);
                    ?>
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
                        <?php foreach ($items as $item) : ?>
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
                                    <p>
                                        <?php if ($currency) : ?>
                                            <?= $currency . ' ' . Yii::$app->currencyHelper->getPrice($currency, $item['price']) ?>
                                        <?php else: ?>
                                            <?= Yii::$app->formatter->asCurrency($item['price']) ?>
                                        <?php endif; ?>
                                    </p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <span class="cart_quantity_up"> + </span>
                                        <?= $form->field($model, 'quantity')
                                            ->input('number', [
                                                'class' => 'cart_quantity_input',
                                                'data-id' => $item['id'],
                                                'value' => $item['amount'],
                                                'min' => 1,
                                                'max' => 3,
                                                'id' => 'carthandler-quantity' . '-' . $item['id']
                                            ])
                                            ->label(false) ?>
                                        <span class="cart_quantity_down"> - </span>
                                    </div>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete"
                                       href="<?= Url::to(['/cart/default/delete', 'id' => $item['id']]) ?>"><i
                                                class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="12" class="cart_total_price"><?= Yii::t('table', 'Total price') ?>
                                : <?= Html::tag('span', Yii::$app->currencyHelper->getPrice($currency, $total), ['class' => 'total']) ?></td>
                        </tr>
                        <tr class="controls">
                            <td><a
                                        href="<?= Url::to(['/site/index']) ?>"><?= Yii::t('table', 'Continue shopping') ?></a>
                            </td>
                            <td class="cart_checkout"><input type="submit" name="Checkout"
                                                             value="<?= Yii::t('table', 'Checkout') ?>"></td>
                            <td><a
                                        href="<?= Url::to(['/cart/default/clear']) ?>"><?= Yii::t('table', 'Clear cart') ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php
                    ActiveForm::end();
                    ?>
                </div>
                <?php
            } else {
                echo Html::tag('div', Yii::t('table', 'Your basket is empty'), ['class' => 'empty-list']);
            }
            ?>
        </div>
    </section> <!--/#cart_items-->

<?php
$this->registerJsFile('js/cart.js', ['depends' => \yii\web\JqueryAsset::class]);
