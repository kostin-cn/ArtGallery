<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\entities\SelectPrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="select-price-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'min')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'max')->textInput(['type' => 'number']) ?>
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
