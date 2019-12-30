<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Arrear */

$this->title = 'Update Arrear: ' . $model->bcc;
$this->params['breadcrumbs'][] = ['label' => 'Arrears', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bcc, 'url' => ['view', 'id' => $model->bcc]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="arrear-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
