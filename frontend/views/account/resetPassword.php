<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\forms\ResetPasswordForm */

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Сброс пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password personal h-80">
    <div class="wrapper">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

        <p><?= Yii::t('app', 'Введите новый пароль');?>:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn-link']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
