<?php
/* @var $this yii\web\View */
/* @var $model common\entities\Rent */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Аренда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
