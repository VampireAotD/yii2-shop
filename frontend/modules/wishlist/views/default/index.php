<?php
/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('table','Wishlist');
$this->params['breadcrumbs'][] = $this->title;
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
<section id="cart_items">
    <div class="container">
        <?php if ($wishlist) { ?>
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image"><?= Yii::t('table', 'Item') ?></td>
                        <td class="description"><?= Yii::t('table', 'Name') ?></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($wishlist as $good) {
                        /**
                         * @var $good \frontend\models\Goods
                         */
                        ?>
                        <tr>
                            <td class="cart_product">
                                <a href="<?= Url::to(['/good/default/index', 'id' => $good->id]) ?>"><img
                                            src="<?= $good->getImage() ?>" width="200px" alt="<?= $good->name ?>"
                                            title="<?= $good->name ?>"></a>
                            </td>
                            <td class="cart_description">
                                <h4>
                                    <a href="<?= Url::to(['/good/default/index', 'id' => $good->id]) ?>"><?= $good->name ?></a>
                                </h4>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete"
                                   href="<?= Url::to(['/wishlist/default/delete', 'id' => $good->id]) ?>"><i
                                            class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    echo "<tr><td colspan='12' class='cart_clear'><a href='" . Url::to(['/wishlist/default/clear']) . "'>
                    " . Yii::t('table', 'Clear wishlist') . "
                    </a></td></tr>";
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            echo Html::tag('div', Yii::t('table','Your wishlist is empty'), ['class' => 'empty-list']);
        }
        ?>
    </div>
</section> <!--/#cart_items-->