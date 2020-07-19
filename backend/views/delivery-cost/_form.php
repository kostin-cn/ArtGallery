<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\entities\DeliveryCost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-cost-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-3">
                    <?= $form->field($model, 'cost')->textInput(['type' => 'number']) ?>
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
