<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\InfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'iin_bin',
            'name_ru',
            'name_kk',
            'total_arrear',
            //'total_tax_arrear',
            //'pension_contribution_arrear',
            //'social_contribution_arrear',
            //'social_health_insurance_arrear',
            //'send_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
