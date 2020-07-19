<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Modules;

/* @var $this yii\web\View */
/* @var $model common\entities\Modules */

$this->title = $model->title ?: 'Модуль';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modules-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' =>
            'btn btn-primary']) ?>
    </p>
    <div class="box">
        <div class="box-body">
            <?= $model->image_name ? DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Изображение',
                        'format' => 'raw',
                        'value' => function (Modules $data) {
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
                            $model->html_en ? [
                                'attribute' => 'html_en',
                                'format' => 'raw'
                            ] : false,
                        ])
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => array_filter([
                            $model->link ? 'link' : false,
                            $model->link_text_ru ? 'link_text_ru' : false,
                            $model->link_text_en ? 'link_text_en' : false,
                        ])
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
