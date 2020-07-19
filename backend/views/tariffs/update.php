<?php

/* @var $this yii\web\View */
/* @var $model common\entities\Tariffs */

$this->title = 'Изменить: ' . $model::VARIANTS[$model->category];
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model::VARIANTS[$model->category], 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="socials-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
