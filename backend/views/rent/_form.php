<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\entities\Rent */
/* @var $form yii\widgets\ActiveForm */

$statusArr = [
        0 => 'Новый',
        1 => 'Подтверждён',
        2 => 'Отменён',
];
?>

<div class="rent-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-3">

                    <?= $form->field($model, 'per_month')->textInput() ?>

                    <?= $form->field($model, 'date')->widget(
                        DatePicker::class, [
                        // inline too, not bad
                        'language' => 'ru',
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'todayBtn' => true,
                            'autoclose' => true,
                            'format' => 'dd.mm.yyyy',
                        ]
                    ]); ?>

                    <?= $form->field($model, 'status')->dropDownList($statusArr) ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'user_id')->textInput(['placeHolder' => $model->user->username, 'disabled' => 'disabled']) ?>

                    <?= $form->field($model, 'product_id')->textInput(['placeHolder' => $model->product->title_ru, 'disabled' => 'disabled']) ?>

                    <?= $form->field($model, 'tariff_id')->textInput(['placeHolder' => $model->tariff->period, 'disabled' => 'disabled']) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
