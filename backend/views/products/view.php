<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\entities\Products */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->category->title, 'url' => ['index', 'slug' => $model->category->slug]];
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
            if ($model->status == 1) {
                echo Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $model->id], ['class' => 'btn btn-success btn-raised pull-right']);
            }else {
                echo Html::a('<span class="glyphicon glyphicon-ok"></span> Продан', ['status', 'id' => $model->id], ['class' => 'btn btn-success btn-raised pull-right']);
            }
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
                            'title_ru',
                        ],
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'title_en',
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'author',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::tag('span', $data->author->title_ru);
                                }
                            ],
                            [
                                'attribute' => 'category_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::tag('span', $data->category->title_ru);
                                }
                            ],
                            'price',
                            'width',
                            'height',
                            [
                                'attribute' => 'format_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::tag('span', $data->format->title_ru);
                                }
                            ],
                            [
                                'label' => 'Материалы',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $result = '';
                                    foreach ($data->materials as $material) {
                                        $result = $result . $material->title_ru . ', ';
                                    };
                                    return $result;
                                }
                            ],
                            [
                                'label' => 'Цвета',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    $result = '';
                                    foreach ($data->colors as $color) {
                                        $result = $result . $color->title_ru . ', ';
                                    };
                                    return $result;
                                }
                            ],
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
                            [
                                'label' => 'Изображение',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->image_name) {

                                        return Html::img($data->image, [
                                            'alt' => 'yii2 - картинка в gridview',
                                            'style' => 'height:450px;'
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
                            'material_ru',
                            [
                                'attribute' => 'description_ru',
                                'format' => 'raw'
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
                            'material_en',
                            [
                                'attribute' => 'description_en',
                                'format' => 'raw'
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h3 style="font-size: 2em">Аренда</h3>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'in_rent',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->in_rent) {
                                        return Html::tag('span', 'Да');
                                    } else {
                                        return Html::tag('span', 'Нет');
                                    }
                                }
                            ],
                            'rent_to:datetime',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
