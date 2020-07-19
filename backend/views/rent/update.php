<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Rent */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Аренда', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="rent-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
