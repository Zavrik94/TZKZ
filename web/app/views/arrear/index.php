<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\\ArrearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Arrears';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arrear-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Arrear', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_iin_bin',
            'organisation_char_code',
            'bcc',
            'bcc_name_ru',
            'bcc_name_kz',
            //'tax_arrear',
            //'poena_arrear',
            //'percent_arrear',
            //'fine_arrear',
            //'total_arrear',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
