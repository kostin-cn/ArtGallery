<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\entities\Products */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Предложенные работы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->status) {
            echo Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $model->id], ['class' => 'btn btn-success btn-raised pull-right']);
        } else {
            echo Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $model->id], ['class' => 'btn btn-danger btn-raised pull-right']);
        }; ?>
    </p>

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'price',
                            'size',
                            [
                                'attribute' => 'has_frame',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->has_frame) {
                                        return Html::tag('text', 'Да');
                                    } else {
                                        return Html::tag('text', 'Нет');
                                    }
                                }
                            ],
                            [
                                'attribute' => 'in_stock',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->in_stock) {
                                        return Html::tag('text', 'Да');
                                    } else {
                                        return Html::tag('text', 'Нет');
                                    }
                                }
                            ],
                            [
                                'attribute' => 'free_storage',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->free_storage) {
                                        return Html::tag('text', 'Да');
                                    } else {
                                        return Html::tag('text', 'Нет');
                                    }
                                }
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Изображение',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->image_name) {

                                        return Html::img($data->image, [
                                            'alt' => 'yii2 - картинка в gridview',
                                            'style' => 'height:100px;'
                                        ]);
                                    }
                                    return false;
                                },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'phone',
                            'author_ru',
                            'title_ru',
                            'material_ru',
                            [
                                'attribute' => 'description_ru',
                                'format' => 'raw'
                            ],
                            [
                                'attribute' => 'select',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->select) {
                                        return Html::a('<span class="glyphicon glyphicon-ok"></span> Выбран', ['select', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                    } else {
                                        return Html::a('<span class="glyphicon glyphicon-remove"></span> Не выбран', ['select', 'id' => $data->id], ['class' => 'btn btn-danger btn-raised']);
                                    }
                                }
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'link',
                            'author_en',
                            'title_en',
                            'material_en',
                            [
                                'attribute' => 'description_en',
                                'format' => 'raw'
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
