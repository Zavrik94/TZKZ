<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'iin_bin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_kk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_arrear')->textInput() ?>

    <?= $form->field($model, 'total_tax_arrear')->textInput() ?>

    <?= $form->field($model, 'pension_contribution_arrear')->textInput() ?>

    <?= $form->field($model, 'social_contribution_arrear')->textInput() ?>

    <?= $form->field($model, 'social_health_insurance_arrear')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
