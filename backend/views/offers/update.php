<?php
/* @var $this yii\web\View */
/* @var $model \common\entities\Products */

$this->title = 'Изменить: ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Предложенные работы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="products-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
