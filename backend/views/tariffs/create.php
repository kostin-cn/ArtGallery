<?php

/* @var $this yii\web\View */
/* @var $model common\entities\Tariffs */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socials-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
