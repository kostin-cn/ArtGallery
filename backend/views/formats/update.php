<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Formats */

$this->title = 'Изменить: ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Форматы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="formats-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
