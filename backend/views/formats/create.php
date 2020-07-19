<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Formats */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Форматы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formats-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
