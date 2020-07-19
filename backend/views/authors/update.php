<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Authors */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Художники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="colors-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
