<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\entities\Tariffs */

$this->title = $model::VARIANTS[$model->category];
$this->params['breadcrumbs'][] = ['label' => 'Тарифы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socials-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->status) {
            echo Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $model->id], ['class' => 'btn btn-success btn-raised pull-right']);
        } else {
            echo Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $model->id], ['class' => 'btn btn-danger btn-raised pull-right']);
        }; ?>
    </p>

    <div class="row">
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'sort',
                        'value' => function ($model) {
                            return $model->sort + 1;
                        }
                    ],
                    [
                        'label' => 'Категория',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data::VARIANTS[$data->category];
                        },
                    ],
                    'period',
                    'price',
                    'price_per_month',
                ],
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'html_ru',
                        'format' => 'raw'
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'html_en',
                        'format' => 'raw'
                    ]
                ],
            ]) ?>
        </div>
    </div>

</div>

