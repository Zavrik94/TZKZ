<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organisation */

$this->title = 'Update Organisation: ' . $model->char_code;
$this->params['breadcrumbs'][] = ['label' => 'Organisations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->char_code, 'url' => ['view', 'id' => $model->char_code]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organisation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
