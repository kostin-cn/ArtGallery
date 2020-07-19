<?php
/* @var $this yii\web\View */
/* @var $model common\entities\DeliveryCost */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Стоимость доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="delivery-cost-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
