<?php

namespace common\components;

use yii\web\UploadedFile;

interface StorageInterface
{
    public function saveFile(UploadedFile $file, $currentFile = null, $path = '@uploads');
    public function getFile($filename,$folder = null);
}