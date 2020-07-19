<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\Products;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category \common\entities\ProductCategories */

$this->title = 'Предложенные работы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">
    <div class="box">
        <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        'title_ru',
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
                        'price',
                        [
                            'attribute' => 'approved',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->approved) {
                                    return Html::a('<span class="glyphicon glyphicon-ok"></span> В Каталоге', ['approved', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                } else {
                                    return Html::a('<span class="glyphicon glyphicon-ok"></span> В Каталог', ['approved', 'id' => $data->id], ['class' => 'btn btn-primary btn-raised']);
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
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->status) {
                                    return Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                } else {
                                    return Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $data->id], ['class' => 'btn btn-danger btn-raised']);
                                }
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
        </div>
    </div>
</div>
