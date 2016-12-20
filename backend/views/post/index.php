<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '内容管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'title',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus($model->status);
                },
                'filter' => \common\models\Post::statusList(),
                'headerOptions' => ['width'=> '120']
            ],
            // 'created_at',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
