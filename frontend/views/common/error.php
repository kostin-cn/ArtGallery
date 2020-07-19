<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <div class="wrapper">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            <?= Yii::t('app', 'Во время обработки вашего запроса возникла ошибка.');?>
        </p>
        <p>
            <?= Yii::t('app', 'Если вы думаете что это ошибка сервера, пожалуйста свяжитесь с нами.');?>
        </p>
    </div>
</div>
