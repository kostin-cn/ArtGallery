<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use vova07\imperavi\Widget;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \common\entities\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'author_ru')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'author_id')->widget(Select2::class, [
                                'data' => $model::getAuthorsList(),
                                'options' => ['placeholder' => 'Выберите ...', 'multiple' => false],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                            <?= $form->field($model, 'category_id')->widget(Select2::class, [
                                'data' => $model::getCategoriesList(),
                                'options' => ['placeholder' => 'Выберите ...', 'multiple' => false],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10,
                                    'allowClear' => false
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                                'mask' => '+7 (999) 999-99-99',
                            ]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6">
                                    <?= $form->field($model, 'height')->input('number') ?>
                                </div>
                                <div class="col-6">
                                    <?= $form->field($model, 'width')->input('number') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'format_id')->widget(Select2::class, [
                                'data' => $model::getFormatsList(),
                                'options' => ['placeholder' => 'Выберите ...', 'multiple' => false],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'material_ru')->textarea(['rows' => 4, 'maxlength' => true]) ?>
                        </div>
                        <div class="col-6">
                            <!--                            --><? //= $form->field($model, 'material_en')->textarea(['rows' => 2, 'maxlength' => true]) ?>
                            <?= $form->field($model, 'materials')->widget(Select2::class, [
                                'data' => $model::getMaterialsList(),
                                'options' => ['placeholder' => 'Выберите ...', 'multiple' => true],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                            <?= $form->field($model, 'colors')->widget(Select2::class, [
                                'data' => $model::getColorsList(),
                                'options' => ['placeholder' => 'Выберите ...', 'multiple' => true],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ' '],
                                    'maximumInputLength' => 10
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($model, 'description_ru')->widget(Widget::class, [
                                'settings' => [
                                    'lang' => 'ru',
                                    'minHeight' => 200,
                                ]
                            ]); ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($model, 'description_en')->widget(Widget::class, [
                                'settings' => [
                                    'lang' => 'ru',
                                    'minHeight' => 200,
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">

                            <?= $form->field($model, 'select')->checkbox() ?>
                            <?= $form->field($model, 'has_frame')->checkbox() ?>
                            <?= $form->field($model, 'in_stock')->checkbox() ?>
                            <?= $form->field($model, 'free_storage')->checkbox() ?>
                        </div>
                    </div>
                    <h3 style="font-size: 36px">Аренда</h3>
                    <div class="row">
                        <div class="col-3">
                            <?= $form->field($model, 'in_rent')->checkbox() ?>
                        </div>
                        <div class="col-3">
                            <?= $form->field($model, 'rent_to')->widget(
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
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <?php
                    $img = ($model->image_name) ? $model->image : '/files/default_thumb.png';
                    $label = Html::img($img, ['class' => 'preview_image_block', 'alt' => 'Image of ' . $model->id]) . "<span>Изображение</span>";
                    ?>
                    <?= $form->field($model, 'uploadedImageFile', ['options' => ['class' => 'img_input_block']])
                        ->fileInput(['class' => 'hidden-input img-input', 'accept' => 'image/*'])->label($label, ['class' => 'label-img']); ?>
                </div>
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
