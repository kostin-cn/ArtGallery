<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\entities\Colors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="colors-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
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
