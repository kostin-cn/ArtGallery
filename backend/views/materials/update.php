<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Materials */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="materials-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
