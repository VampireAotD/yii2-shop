<?php
namespace backend\models\forms;

use yii\base\Model;

class ImageUpload extends Model
{
    public $image;

    public function rules()
    {
        return [
          ['image', 'file', 'extensions' => ['jpg', 'svg', 'gif', 'png', 'jpeg'], 'skipOnEmpty' => false]
        ];
    }
}