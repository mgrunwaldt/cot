<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BusRoutes */

$this->title = 'Update Bus Routes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bus Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bus-routes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
