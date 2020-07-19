<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\Rent;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Аренда';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-index">
        
    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <div class="box">
        <div class="box-body">
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                    'created_at:datetime',
                    [
                        'label' => 'Пользователь',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->user->username) {
                                return Html::tag('span', $data->user->username);
                            }
                            return false;
                        },
                    ],
                    [
                        'label' => 'Изображение',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->product->image_name) {

                                return Html::img($data->product->image, [
                                    'alt' => 'yii2 - картинка в gridview',
                                    'style' => 'height:100px;'
                                ]);
                            }
                            return false;
                        },
                    ],
                    [
                        'label' => 'Название картины',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->product->title_ru) {
                                return Html::a($data->product->title_ru, ['products/view', 'id' => $data->product_id]);
                            }
                            return false;
                        },
                    ],
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

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
                                </div>
    </div>
</div>
