<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Abouts;

/* @var $this yii\web\View */
/* @var $model common\entities\Abouts */

$this->title = $model->title ?: 'Блоки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modules-view">

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
            <?= $model->image_name ? DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Изображение',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->image_name) {
                                return Html::img($data->image, [
                                    'alt' => 'yii2 - картинка в gridview',
                                    'style' => 'width:600px;'
                                ]);
                            }
                            return null;
                        },
                    ],
                ],
            ]) : '' ?>
            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => array_filter([
                            $model->title_ru ? 'title_ru' : false,
                            $model->title_ru ? 'sub_title_ru' : false,
                            $model->html_ru ?
                                [
                                    'attribute' => 'html_ru',
                                    'format' => 'raw'
                                ] : false,
                        ])
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => array_filter([
                            $model->title_en ? 'title_en' : false,
                            $model->title_en ? 'sub_title_en' : false,
                            $model->html_en ? [
                                'attribute' => 'html_en',
                                'format' => 'raw'
                            ] : false,
                        ])
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
