<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\SelectPrice;

/* @var $this yii\web\View */
/* @var $model common\entities\SelectPrice */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Select Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="select-price-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' =>
        'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
        'confirm' => 'Вы точно хотите удалить эту запись?',
        'method' => 'post',
        ],
        ]) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'min',
            'max',
            ],
            ]) ?>

        </div>
    </div>
</div>
