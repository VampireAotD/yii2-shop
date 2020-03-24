<?php
/**
 * @var $this \yii\web\View
 * @var $good \backend\models\Goods
 * @var $imageUpload \backend\modules\goods\models\forms\ImageUpload
 */

$this->title = 'Upload image';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $good->name, 'url' => ['view', 'id' => $good->id]];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo Html::tag('div',Html::img($good->getImage(),['class' => 'preview-image']),['class' => 'preview-block']);
echo $form->field($imageUpload,'image')->fileInput(['accept' => 'image/*', 'class' => 'image-input'])->label('Выберите изображение для товара');
echo Html::tag('p', '', ['class' => 'alert image-status display-none']);
echo Html::submitButton('Upload image', ['class' => 'btn btn-success']);

ActiveForm::end();

$this->registerJsFile('js/preview-image.js', ['depends' => JqueryAsset::class]);