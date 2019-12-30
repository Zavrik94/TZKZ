<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Organisation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organisation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'char_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_kk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report_acrual_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
