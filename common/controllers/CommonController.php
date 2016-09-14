<?php
namespace common\controllers;

use yii\web\Controller;
use yii\helpers\Json;

/**
 * Common controller
 */
class CommonController extends Controller
{
    const CODE_SUCCESS = 200;
    const CODE_ERROR = 0;

    public function responseAjax($data = [])
    {
        $data = [
            'status'  => isset($data['status']) ? intval($data['status']) : 200,
            'message' => !empty($data['message']) ? trim($data['message']) : '',
            'data'    => isset($data['data']) ? $data['data'] : array(),
        ];
        exit(Json::encode($data));
    }

    public function successAjax($message = '', $data = array())
    {
        $message || $message = 'success';
        $this->responseAjax(['status' => self::CODE_SUCCESS, 'message' => $message, 'data' => $data]);
    }

    public function errorAjax($message = '', $data = array())
    {
        $message || $message = 'error';
        $this->responseAjax(['status' => self::CODE_ERROR, 'message' => $message, 'data' => $data]);
    }

}
