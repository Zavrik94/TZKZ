<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\\ArrearSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arrear-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'user_iin_bin') ?>

    <?= $form->field($model, 'organisation_char_code') ?>

    <?= $form->field($model, 'bcc') ?>

    <?= $form->field($model, 'bcc_name_ru') ?>

    <?= $form->field($model, 'bcc_name_kz') ?>

    <?php // echo $form->field($model, 'tax_arrear') ?>

    <?php // echo $form->field($model, 'poena_arrear') ?>

    <?php // echo $form->field($model, 'percent_arrear') ?>

    <?php // echo $form->field($model, 'fine_arrear') ?>

    <?php // echo $form->field($model, 'total_arrear') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
