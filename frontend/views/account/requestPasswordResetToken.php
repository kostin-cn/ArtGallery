<?php

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\forms\PasswordResetRequestForm */

$this->title = Yii::t('app', 'Запрос сброса пароля');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset personal h-80">
    <div class="wrapper">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

        <p><?= Yii::t('app', 'Введите ваш E-mail, на него будет отправлена ссылка для сброса пароля.');?></p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Отправить'), ['class' => 'btn-link']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
