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
            [
                'attribute' => 'bcc',
                'value' => function (\app\models\Arrear $data) {
                    return Html::a(Html::encode($data->bcc), \yii\helpers\Url::to(['arrear/view', 'id' => $data->bcc]));
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'user_iin_bin',
                'value' => function (\app\models\Arrear $data) {
                    return Html::a(Html::encode($data->user_iin_bin), \yii\helpers\Url::to(['user/view', 'id' => $data->user_iin_bin]));
                },
                'format' => 'raw'
            ],
            ['attribute' => 'organisation_char_code',
                'value' => function (\app\models\Arrear $data) {
                    return Html::a(Html::encode($data->organisation_char_code), \yii\helpers\Url::to(['organisation/view', 'id' => $data->organisation_char_code]));
                },
                'format' => 'raw'],
            'bcc_name_ru',
            'total_arrear',

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

