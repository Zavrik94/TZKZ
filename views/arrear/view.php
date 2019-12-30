<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Arrear */

$this->title = $model->bcc;
$this->params['breadcrumbs'][] = ['label' => 'Arrears', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="arrear-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bcc], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bcc], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_iin_bin',
            'organisation_char_code',
            'bcc',
            'bcc_name_ru',
            'bcc_name_kz',
            'tax_arrear',
            'poena_arrear',
            'percent_arrear',
            'fine_arrear',
            'total_arrear',
        ],
    ]) ?>

</div>
