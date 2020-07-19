<?php
/* @var $this yii\web\View */
/* @var $model common\entities\SelectPrice */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Select Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="select-price-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
