<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限控制管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('分类添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'     => 'id',
                'headerOptions' => ['width' => '80']
            ],
            [
                'attribute' => 'parent_id',
                'value' => function($model) {
                    $category = $model->findOne($model->parent_id);
                    return $category['name'];
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->getAuthorName($model->user_id);
                }
            ],
            'name',
            //'sort',
            // 'status',
            // 'created_at',
            // 'updated_at',
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
