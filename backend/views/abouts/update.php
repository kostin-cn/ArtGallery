<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Abouts */

$this->title = 'Изменить: ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="modules-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
