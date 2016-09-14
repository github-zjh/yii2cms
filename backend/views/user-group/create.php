<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */

$this->title = '用户组添加';
$this->params['breadcrumbs'][] = ['label' => '用户组管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
