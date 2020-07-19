<?php

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\forms\LoginForm */

$this->title = Yii::t('app', 'Вход');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="wrapper">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

        <p><?= Yii::t('app', 'Заполните следующие поля для входа');?>:</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'form-group data-checkbox'], 'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"])->checkbox() ?>

        <div style="color:#999;margin:1em 0">
            <span><?= Yii::t('app', 'Если вы забыли свой пароль, вы можете');?> </span>
            <?= Html::a(Yii::t('app', 'сбросить его'), ['account/request-password-reset']) ?>.
        </div>
        <div style="color:#999;margin:1em 0">
            <span><?= Yii::t('app', 'Если у вас нет аккаунта');?>, </span>
            <?= Html::a(Yii::t('app', 'зарегистрируйтесь'), ['account/signup']) ?>.
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'btn-link black wide', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
