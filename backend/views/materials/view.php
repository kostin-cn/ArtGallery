<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Materials;

/* @var $this yii\web\View */
/* @var $model common\entities\Materials */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Материалы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materials-view">

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
            'title_ru',
            'title_en',
            'sort',
            ],
            ]) ?>

        </div>
    </div>
</div>
