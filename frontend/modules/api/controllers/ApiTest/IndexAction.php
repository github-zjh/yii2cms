<?php
/**
 * Created by PhpStorm.
 * User: zjh
 * Date: 2016/6/15
 * Time: 11:38
 */
namespace frontend\modules\api\controllers\ApiTest;

use Yii;
use yii\rest\action;
use yii\data\ActiveDataProvider;

class IndexAction extends Action
{
    public $modelClass = 'common\models\User';
    public function run()
    {
        echo 'Api Module Works';die;
    }
}