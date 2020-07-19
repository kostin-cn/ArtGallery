<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\entities\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modules-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">

            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'title_ru')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'html_ru')->widget(Widget::class, [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 200,
                        ]
                    ]); ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'title_en')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'html_en')->widget(Widget::class, [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 200,
                        ]
                    ]); ?>
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
