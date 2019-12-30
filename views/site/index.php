<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Arrear */
/* @var $dataProvider app\models\Arrear */
/* @var $searchModel app\models\Arrear */

$this->title = 'Check IIN';
?>

<div class="info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'user_iin_bin')->textInput() ?>
        <input type="hidden" id="captcha_id" name="captcha_id" value="">
        <div class="form-group">
            <?= Html::submitButton('Get Info', ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <script type="text/javascript">
        var d = new Date().getTime();
        document.getElementById("captcha_id").value =  'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = (d + Math.random() * 16) % 16 | 0;
            d = Math.floor(d / 16);
            return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
        });
    </script>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'bcc',
            'user_iin_bin',
            'user.name_ru',
            'organisation_char_code',
            'bcc_name_ru',
            'total_arrear',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

