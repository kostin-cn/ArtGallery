<?php
use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\entities\UserAddress */
?>
<div class="add-address-page login-page">

    <div class="wrapper">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'value')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn submit']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>