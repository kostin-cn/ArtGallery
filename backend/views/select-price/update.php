<?php
/* @var $this yii\web\View */
/* @var $model common\entities\SelectPrice */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Select Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="select-price-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
