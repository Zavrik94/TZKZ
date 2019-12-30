<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Arrear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arrear-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_iin_bin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'organisation_char_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bcc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bcc_name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bcc_name_kz')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_arrear')->textInput() ?>

    <?= $form->field($model, 'poena_arrear')->textInput() ?>

    <?= $form->field($model, 'percent_arrear')->textInput() ?>

    <?= $form->field($model, 'fine_arrear')->textInput() ?>

    <?= $form->field($model, 'total_arrear')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
