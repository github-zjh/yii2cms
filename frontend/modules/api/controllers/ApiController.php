<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\User';
}