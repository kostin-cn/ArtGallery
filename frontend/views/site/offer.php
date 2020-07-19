<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View
 * @var $header \common\entities\Modules;
 * @var $model \frontend\forms\OfferForm;
 * @var $form yii\widgets\ActiveForm;
 */
?>
<div class="offer-page">
    <div class="headerBlock respons__block" style="background-image: url('<?= $header->image;?>')">
        <div class="headerText">
            <h1><?= $header->title;?></h1>
            <div class="desc">
                <?= $header->html;?>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="offerContainer">
            <?php $form = ActiveForm::begin(['id' => 'offer-form']); ?>

            <div class="offerBlock first">
                <?= $form->field($model, 'author')->textInput(['autofocus' => true, 'placeholder' => Yii::t('app', 'Имя')]) ?>

                <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                    'mask' => '+7 (999) 999-99-99',
                ]) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Название')]) ?>

                <?= $form->field($model, 'size')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Ширина х высота')]) ?>

                <?= $form->field($model, 'material')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Перечислить через запятую')]) ?>

                <?= $form->field($model, 'price')->textInput(['type' => 'number', 'placeholder' => Yii::t('app', 'Стоимость на продажу')]) ?>
            </div>

            <div class="offerBlock second">
                
                <?= $form->field($model, 'uploadedImageFile')
                    ->fileInput(['accept' => 'image/*', 'language' => Yii::$app->language]); ?>

                <?= $form->field($model, 'has_frame', ['options' => ['class' => 'form-group data-checkbox'], 'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"])->checkbox() ?>

                <?= $form->field($model, 'in_stock', ['options' => ['class' => 'form-group data-checkbox'], 'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"])->checkbox() ?>

                <?= $form->field($model, 'free_storage', ['options' => ['class' => 'form-group data-checkbox'], 'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"])->checkbox() ?>

                <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'data_collection_checkbox', ['options' => ['class' => 'form-group data-checkbox'], 'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"])->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'offer-btn', 'name' => 'offer-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
