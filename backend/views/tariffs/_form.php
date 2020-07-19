<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\entities\Tariffs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="socials-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?php if ($model->isNewRecord): ; ?>
            <div class="col-lg-6">
                <?= $form->field($model, 'category')->dropDownList($model::VARIANTS, ['prompt' => 'Выберите категорию']) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
            <?= $form->field($model, 'price_per_month')->textInput(['type' => 'number']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'html_ru')->widget(Widget::class, [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 100,
                ]
            ]); ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'html_en')->widget(Widget::class, [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 100,
                ]
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
