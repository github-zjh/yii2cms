<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use common\models\User;
use common\models\UserGroup;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('用户列表', ['index'], ['class' => 'btn btn-success active']) ?>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'headerOptions' => ['width'=> '80']
            ],
            'username',
            'email:email',
            [
                'attribute' => 'group_id',
                'value' => function($model) {
                    return UserGroup::findGroupName($model->group_id);
                },
                'filter' => UserGroup::findGroupName(),
                'headerOptions' => ['width'=> '120']
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus($model->status);
                },
                'filter' => User::statusList(),
                'headerOptions' => ['width'=> '120']
            ],
            //'created_at:datetime',
            //'updated_at:datetime',
            [
                'attribute' => 'created_at',
                'format'    => 'datetime',
                'filter'    => DatePicker::widget([
                    'model'         => $searchModel,
                    'attribute'     => 'created_at',
                    'language'      => 'zh-CN',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format'    => 'yyyy-mm-dd'
                    ]
                ]),
                'headerOptions' => ['width'=> '160']
            ],
            [
                'attribute' => 'updated_at',
                'format'    => 'datetime',
                'filter'    => DatePicker::widget([
                    'model'         => $searchModel,
                    'attribute'     => 'updated_at',
                    'language'      => 'zh-CN',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format'    => 'yyyy-mm-dd'
                    ]
                ]),
                'headerOptions' => ['width'=> '160']
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
