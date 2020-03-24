<?php
/**
 * @var $this \yii\web\View
 * @var $slide \backend\models\Slide
 * @var $imageUpload \backend\models\forms\ImageUpload
 */

$this->title = 'Upload image';
$this->params['breadcrumbs'][] = ['label' => 'Slides', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $slide->id, 'url' => ['view', 'id' => $slide->id]];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo Html::tag('div',Html::img($slide->getImage(),['class' => 'preview-image']),['class' => 'preview-block']);
echo $form->field($imageUpload,'image')->fileInput(['accept' => 'image/*', 'class' => 'image-input'])->label('Выберите изображение для товара');
echo Html::tag('p', '', ['class' => 'alert image-status display-none']);
echo Html::submitButton('Upload image', ['class' => 'btn btn-success']);

ActiveForm::end();

$this->registerJsFile('js/preview-image.js', ['depends' => JqueryAsset::class]);