<?php

namespace frontend\modules\api\controllers;

class ApiTestController extends ApiController
{
    public $modelClass = 'common\models\User';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'frontend\modules\api\controllers\ApiTest\IndexAction';
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