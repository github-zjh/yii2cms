<?php

namespace frontend\modules\api;

use yii;
/**
 * api module definition class
 */
class apiModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $version = Yii::$app->request->get('version');
        $module = Yii::$app->getModule($version);
        //echo $action.PHP_EOL;die('loading..');
        //$baseUrl = Yii::$app->request->getBaseUrl();
        //$newUrl = Yii::$app->urlManager->createUrl('v1/api-test');
        //echo $newUrl;
        echo Yii::$app->request->getPathInfo();
        // custom initialization code goes here
    }
}
