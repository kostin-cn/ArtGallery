<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\Products;
use common\entities\Authors;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category \common\entities\ProductCategories */

$this->title = $category->title;
$this->params['breadcrumbs'][] = $this->title;

$authors = Authors::find()->orderBy(['sort' => SORT_ASC])-> all();
$authArr = ArrayHelper::map($authors, 'id', 'title_ru');
?>
<div class="products-index">
    <p>
        <?= Html::a('Добавить', ['create', 'slug' => $category->slug], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'attribute' => 'author_id',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::tag('span', $data->author);
                            },
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'author_id',
                                $authArr,
                                ['class' => 'form-control', 'prompt' => 'Все']
                            ),
                        ],
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
                        [
                            'attribute' => 'price',
                            'format' => 'raw',
                            'value' => function ($data) {
                                return Html::tag('span', $data->price);
                            },
                            'filter' =>
                                Html::activeTextInput(
                                    $searchModel,
                                    'price_min',
                                    ['class' => 'form-control',
                                        'type' => 'number',
                                        'placeholder' => 'От',
                                        'style' => 'width:100px; float:left']
                                ) .
                                Html::activeTextInput(
                                    $searchModel,
                                    'price_max',
                                    ['class' => 'form-control',
                                        'type' => 'number',
                                        'placeholder' => 'До',
                                        'style' => 'width:100px']
                                ),
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
                            },
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'select',
                                ['0' => 'Не выбран', '1' => 'Выбран'],
                                ['class' => 'form-control', 'prompt' => 'Все']
                            ),
                        ],
                        [
                            'attribute' => 'in_rent',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->in_rent) {
                                    return Html::tag('span', 'Да');
                                } else {
                                    return Html::tag('span', 'Нет');
                                }
                            },
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'in_rent',
                                ['0' => 'Нет', '1' => 'Да'],
                                ['class' => 'form-control', 'prompt' => 'Все']
                            ),
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->status) {
                                    if ($data->status == 1) {
                                        return Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                    }else {
                                        return Html::a('<span class="glyphicon glyphicon-ok"></span> Продан', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                    }
                                } else {
                                    return Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $data->id], ['class' => 'btn btn-danger btn-raised']);
                                }
                            },
                            'filter' => Html::activeDropDownList(
                                $searchModel,
                                'status',
                                ['0' => 'Скрывать', '1' => 'Отображать', '2' => 'Продан'],
                                ['class' => 'form-control', 'prompt' => 'Все']
                            ),
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
        </div>
    </div>
</div>
