<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\widgets\DatePicker;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\entities\Articles */
/* @var $form yii\widgets\ActiveForm */

$plugins = [
    'table',
    'imagemanager',
    'fontfamily',
    'fontsize',
    'clips',
    'fullscreen',
    'video',
];
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-4">
                    <?php
                    $img = ($model->image_name) ? $model->image : '/files/default_thumb.png';
                    $label = Html::img($img, ['class' => 'preview_image_block', 'alt' => 'Image of ' . $model->id]) . "<span>Изображение</span>";
                    ?>
                    <?= $form->field($model, 'uploadedImageFile', ['options' => ['class' => 'form-group img_input_block']])
                        ->fileInput(['class' => 'hidden-input img-input', 'accept' => 'image/*'])->label($label, ['class' => 'label-img']); ?>

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
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'title_ru')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'short_descr_ru')->textarea(['rows' => 5, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'description_ru')->widget(Widget::class, [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'imageUpload' => Url::to(['/file-storage/image-upload']),
                            'imageManagerJson' => Url::to(['/file-storage/images-get']),
                            'plugins' => $plugins
                        ]
                    ]); ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'title_en')->textarea(['rows' => 1, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'short_descr_en')->textarea(['rows' => 5, 'maxlength' => true]) ?>
                    <?= $form->field($model, 'description_en')->widget(Widget::class, [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'imageUpload' => Url::to(['/file-storage/image-upload']),
                            'imageManagerJson' => Url::to(['/file-storage/images-get']),
                            'plugins' => $plugins
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
