<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'introduce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->fileInput(
        [
            'data-upload-loading' => Url::to('@web/image/upload_loading.gif'),
            'data-upload-url' => Yii::$app->urlManager->createUrl('user-group/upload'),
            'onChange' => 'uploadSingleImage(this)'
        ]
    ) ?>
    <?php if($model->icon): ?>
        <?= Html::img($model->icon, ['class'=>'pre-image has-val']) ?>
    <?php else:?>
        <?= Html::img('@web/image/upload_loading.gif', ['class'=>'pre-image hidden']) ?>
    <?php endif;?>
    <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>

    <?= $form->field($model, 'sort_order')->textInput(['value'=>'0']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '确认添加' : '保存修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
