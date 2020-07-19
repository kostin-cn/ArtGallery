<?php
/* @var $this yii\web\View */
/* @var $model common\entities\DeliveryCost */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Стоимость доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-cost-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
