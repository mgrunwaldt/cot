<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'administrator_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'provider_id') ?>

    <?= $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'browser') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
