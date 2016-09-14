<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '用户组管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除此项吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'introduce',
            [
                'attribute' => 'icon',
                'value'     => $model->icon ? Html::img($model->icon, ['width' => '60']) : '--',
                'format'    => 'html'
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatus($model->status)
            ],
            'sort_order',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
