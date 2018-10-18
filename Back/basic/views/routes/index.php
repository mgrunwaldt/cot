<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RoutesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="routes-index">
    <?php

    Modal::begin([
        'header' => '<h4>Importar XML</h4>',
        'id'     => 'model',
        'size'   => 'model-lg',
    ]);

    echo "<div id='modelContent'></div>";

    Modal::end();

    ?>




    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Ruta', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::button('Importar XML', ['id' => 'modelButton', 'value' => \yii\helpers\Url::to(['routes/import']), 'class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'number',
            'stop_radius',
            'total_stops',
            //'created_on',
            //'updated_on',
            //'deleted',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
