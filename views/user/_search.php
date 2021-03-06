<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'iin_bin') ?>

    <?= $form->field($model, 'name_ru') ?>

    <?= $form->field($model, 'name_kk') ?>

    <?= $form->field($model, 'total_arrear') ?>

    <?= $form->field($model, 'total_tax_arrear') ?>

    <?php // echo $form->field($model, 'pension_contribution_arrear') ?>

    <?php // echo $form->field($model, 'social_contribution_arrear') ?>

    <?php // echo $form->field($model, 'social_health_insurance_arrear') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
