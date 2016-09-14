<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList($model::getParents()) ?>

    <?= $form->field($model, 'sort')->textInput(['value' => 0]) ?>

    <?= $form->field($model, 'status')->dropDownList($model::statusList()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '确认提交' : '保存修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
