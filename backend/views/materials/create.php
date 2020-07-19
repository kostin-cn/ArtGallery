<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Materials */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materials-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
