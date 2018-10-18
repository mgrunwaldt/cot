<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Administrators */

$this->title = 'Create Administrators';
$this->params['breadcrumbs'][] = ['label' => 'Administrators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administrators-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
