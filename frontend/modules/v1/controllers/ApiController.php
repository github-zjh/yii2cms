<?php

namespace frontend\modules\v1\controllers;

use yii\rest\ActiveController;

class ApiController extends ActiveController
{
    public $modelClass = 'common\models\User';
}