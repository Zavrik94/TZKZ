<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Arrear */

$this->title = 'Create Arrear';
$this->params['breadcrumbs'][] = ['label' => 'Arrears', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arrear-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
