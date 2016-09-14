<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\Alert;
use common\models\UserGroup;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户组管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加用户组', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'introduce',
            //'icon:image',
            [
                'attribute' => 'icon',
                'content' => function($model) {
                    return $model->icon ? Html::img($model->icon, ['width'=> '30']) : '--';
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus($model->status);
                },
                'filter' => UserGroup::statusList(),
                'headerOptions' => ['width'=> '120']
            ],
            // 'sort_order',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
