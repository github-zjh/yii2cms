<?php
/**
 * Created by PhpStorm.
 * User: zjh
 * Date: 2016/6/15
 * Time: 11:38
 */
namespace frontend\modules\v1\controllers\ApiTest;

use Yii;
use yii\rest\action;
use yii\data\ActiveDataProvider;

class IndexAction extends Action
{
    public $modelClass = 'common\models\User';
    public function run()
    {
        echo 'v1 aha';die;
    }
}