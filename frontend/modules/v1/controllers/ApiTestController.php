<?php

namespace frontend\modules\v1\controllers;

class ApiTestController extends ApiController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'frontend\modules\v1\controllers\ApiTest\IndexAction';
//        $actions['index'] = [
//            //'class' => 'frontend\controllers\ApiTest\IndexAction',
//            'modelClass' => $this->modelClass,
//            'checkAccess' => [$this, 'checkAccess'],
//        ];
        //unset($actions['index']);
        //$actions['index']['prepareDataProvider'] = [$this, 'actionIndex'];
        return $actions;
    }
}