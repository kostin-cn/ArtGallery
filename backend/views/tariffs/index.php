<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\Tariffs;
use yii\widgets\Pjax;
use arogachev\sortable\grid\SortableColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\entities\Tariffs */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тарифы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="socials-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <div class="box">
        <div class="box-body">
            <div class="question-index" id="question-sortable">
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'sort',
                        [
                            'class' => SortableColumn::class,
                            'gridContainerId' => 'question-sortable',
                            'baseUrl' => '/admin/sort/', // Optional, defaults to '/sort/'
                            'confirmMove' => false, // Optional, defaults to true
                            'template' => '<div class="sortable-section">{currentPosition}</div>
                                           <div class="sortable-section">{moveWithDragAndDrop}</div>'
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
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($data) {
                                if ($data->status) {
                                    return Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $data->id], ['class' => 'btn btn-success btn-raised']);
                                } else {
                                    return Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $data->id], ['class' => 'btn btn-danger btn-raised']);
                                }
                            },
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

