<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Colors */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Цвета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colors-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
