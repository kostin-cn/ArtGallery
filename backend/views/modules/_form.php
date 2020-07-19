<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\entities\Modules */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modules-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">

            <div class="row">
                <?php if (!in_array($model->id, [2, 5]) or $model->isNewRecord): ; ?>
                <div class="col-6">
                    <?php
                    $img = ($model->image_name) ? $model->image : '/files/default_thumb.png';
                    $label = Html::img($img, ['class' => 'preview_image_block', 'alt' => 'Image of ' . $model->id]) . "<span>Изображение</span>";
                    ?>
                    <?= $form->field($model, 'uploadedImageFile', ['options' => ['class' => 'img_input_block']])
                        ->fileInput(['class' => 'hidden-input img-input', 'accept' => 'image/*'])->label($label, ['class' => 'label-img']); ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-6">
                    <?php if (!in_array($model->id, [3]) or $model->isNewRecord): ; ?>
                        <?= $form->field($model, 'title_ru')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?php endif; ?>

                    <?php if (!in_array($model->id, [3]) or $model->isNewRecord): ; ?>
                        <?= $form->field($model, 'html_ru')->widget(Widget::class, [
                            'settings' => [
                                'lang' => 'ru',
                                'minHeight' => 200,
                            ]
                        ]); ?>
                    <?php endif; ?>
                </div>
                <div class="col-6">
                    <?php if (!in_array($model->id, [3]) or $model->isNewRecord): ; ?>
                        <?= $form->field($model, 'title_en')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?php endif; ?>

                    <?php if (!in_array($model->id, [3]) or $model->isNewRecord): ; ?>
                        <?= $form->field($model, 'html_en')->widget(Widget::class, [
                            'settings' => [
                                'lang' => 'ru',
                                'minHeight' => 200,
                            ]
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?php if (in_array($model->id, [2]) or $model->isNewRecord): ; ?>
                        <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-6">
                            <?php if (in_array($model->id, [2]) or $model->isNewRecord): ; ?>
                                <?= $form->field($model, 'link_text_ru')->textInput(['maxlength' => true]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-6">
                            <?php if (in_array($model->id, [2]) or $model->isNewRecord): ; ?>
                                <?= $form->field($model, 'link_text_en')->textInput(['maxlength' => true]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
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
