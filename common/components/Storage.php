<?php
namespace common\components;
use Yii;
use yii\base\Component;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Storage extends Component implements StorageInterface
{
    private $filename;
    const DEFAULT_IMAGE = 'no-image.jpg';

    public function saveFile(UploadedFile $file, $currentFile = null, $path = '@uploads')
    {
        $filename = $this->getFilename($file);

        $this->deletePreviousImage($currentFile);

        if(FileHelper::createDirectory(Yii::getAlias($path)) && $file->saveAs(Yii::getAlias($path.'/'.$filename))){
            return $this->filename;
        }
    }

    public function getFile($filename, $folder = null)
    {
        if(empty($filename)){
            $filename = self::DEFAULT_IMAGE;
        }
        return Yii::$app->params['storagePath'].$folder.$filename;
    }

    public function deletePreviousImage($filename,$path = '@uploads'){
        if(FileHelper::findFiles(Yii::getAlias($path,['only' => [$filename]]))){
            FileHelper::unlink(Yii::getAlias($path.'/'.$filename));
        }
    }

    private function getFilename(UploadedFile $file){
        return $this->filename = strtolower(uniqid(md5($file->baseName))).'.'.$file->extension;
    }
}