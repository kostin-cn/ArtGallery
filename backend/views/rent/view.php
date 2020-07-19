<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Rent;

/* @var $this yii\web\View */
/* @var $model common\entities\Rent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Аренда', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-view">

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

            <div class="row">
                <div class="col-lg-6">
                    <h3 style="font-size: 3em">Пользователь</h3>
                    <?= DetailView::widget([
                        'model' => $model->user,
                        'attributes' => [
                            'username',
                            'email',
                            'phone',
                            [
                                'label' => 'Город',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->userAddresses[0]) {
                                        return Html::tag('span', $data->userAddresses[0]->value);
                                    }
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Улица',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->userAddresses[0]) {
                                        return Html::tag('span', $data->userAddresses[0]->street);
                                    }
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Дом',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->userAddresses[0]) {
                                        return Html::tag('span', $data->userAddresses[0]->house);
                                    }
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Квартира/Офис',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->userAddresses[0]) {
                                        return Html::tag('span', $data->userAddresses[0]->apartment);
                                    }
                                    return null;
                                },
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <h3 style="font-size: 3em">Картина</h3>
                    <?= DetailView::widget([
                        'model' => $model->product,
                        'attributes' => [
                            [
                                'label' => 'Изображение',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->image_name) {
                                        return Html::img($data->image, [
                                            'alt' => 'yii2 - картинка в gridview',
                                            'style' => 'width:200px;'
                                        ]);
                                    }
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Название картины',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->title_ru) {
                                        return Html::a($data->title_ru, ['products/view', 'id' => $data->id]);
                                    }
                                    return false;
                                },
                            ],
                            [
                                'label' => 'Автор',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->author) {
                                        return Html::tag('span', $data->author->title_ru);
                                    }
                                    return null;
                                },
                            ],
                            [
                                'label' => 'Телефон автора',
                                'format' => 'raw',
                                'value' => function ($data) {
                                        return Html::tag('span', $data->phone);
                                },
                            ],
                            [
                                'label' => 'Размер',
                                'format' => 'raw',
                                'value' => function ($data) {
                                        return Html::tag('span', $data->width) . 'x' . Html::tag('span', $data->height);
                                },
                            ],
                            'price',
                        ],
                    ]) ?>
                </div>
            </div>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Период',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->tariff->period) {
                            return Html::tag('span', $data->tariff->period);
                        }
                        return false;
                    },
                ],
            'per_month',
            'date:datetime',
            'created_at:datetime',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($data) {
                        if ($data->status) {
                            if ($data->status == 1) {
                                return Html::a('<span class="glyphicon glyphicon-ok"></span> Подтверждён', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                            }else {
                                return Html::a('<span class="glyphicon glyphicon-remove"></span> Отменён', ['status', 'id' => $data->id], ['class' => 'btn btn-danger btn-raised']);
                            }
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span> Новый', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                        }
                    }
                ],
            ],
            ]) ?>

        </div>
    </div>
</div>
