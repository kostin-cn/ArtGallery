<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Articles;

/* @var $this yii\web\View */
/* @var $model common\entities\Articles */

$this->title = $model->title_ru;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

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
        <?php if ($model->status) {
            echo Html::a('<span class="glyphicon glyphicon-ok"></span> Отображать', ['status', 'id' => $model->id], ['class' => 'btn btn-success btn-raised pull-right']);
        } else {
            echo Html::a('<span class="glyphicon glyphicon-remove"></span> Скрывать', ['status', 'id' => $model->id], ['class' => 'btn btn-danger btn-raised pull-right']);
        }; ?>
    </p>
    <div class="box">
        <div class="box-body">
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
                                    'style' => 'width:300px;'
                                ]);
                            }
                            return null;
                        },
                    ],
                    [
                        'attribute' => 'date',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDate($data->date, 'dd.MM.yyyy');
                        },
                    ],
                ],
            ]) ?>

            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'title_ru',
                            [
                                'attribute' => 'short_descr_ru',
                                'format' => 'raw'
                            ],
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
                            'title_en',
                            [
                                'attribute' => 'short_descr_en',
                                'format' => 'raw'
                            ],
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
