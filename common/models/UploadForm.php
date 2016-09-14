<?php
/**
 * Created by PhpStorm.
 * User: 赵金涵
 * Date: 2016/8/16
 * Time: 11:00
 */
namespace common\models;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $image;
    public $uploadRoot = '';
    public $uploadUrl  = '';
    public $saveUrl    = '';
    public $error      = '';

    private $savePath = '';

    public function init()
    {
        parent::init();
        $uploadConfig = Yii::$app->params['upload'];
        $this->uploadRoot = $uploadConfig['rootDir'] . DIRECTORY_SEPARATOR . $uploadConfig['baseDir'];
        $this->uploadUrl = '/' . $uploadConfig['baseDir'];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['image'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024*2]
        ];
    }

    public function uploadImage($model, $attribute = '')
    {
        if (Yii::$app->request->isPost) {
            $this->image = UploadedFile::getInstance($model, $attribute);
            if ($this->image) {
                if($this->validate()){
                    $this->error = '';
                    $this->getSavePath($this->image);
                    return $this->image->saveAs($this->savePath);
                } else {
                    $this->error = $this->getFirstError('image');
                }
            }
        }
        return false;
    }

    public function uploadFile($model, $attribute = '')
    {
        if (Yii::$app->request->isPost) {
            $this->file = UploadedFile::getInstance($model, $attribute);
            if ($this->file) {
                if($this->validate()){
                    $this->error = '';
                    $this->getSavePath($this->file);
                    return $this->file->saveAs($this->savePath);
                } else {
                    $this->error = $this->getFirstError('file');
                }
            }
        }
        return false;
    }

    public function getSavePath($file)
    {
        $saveDir = DIRECTORY_SEPARATOR . date('Ymd');
        $dir = $this->uploadRoot . $saveDir;
        if(!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $fileName =  $this->getRandName($file->extension);
        $this->saveUrl = $this->uploadUrl . preg_replace('/[\\\\\/]+/', '/', '//\\/'.$saveDir . DIRECTORY_SEPARATOR . $fileName);
        $this->savePath = $dir . DIRECTORY_SEPARATOR . $fileName;
        return true;
    }

    protected function getRandName($extension = '')
    {
        $rand = substr(md5(uniqid(mt_rand())), 0, 10) . '.' . $extension;
        return $rand;
    }
}