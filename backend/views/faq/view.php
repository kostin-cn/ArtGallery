<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\Faq;

/* @var $this yii\web\View */
/* @var $model common\entities\Faq */

$this->title = $model->title ?: 'Faq';
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
        </div>
    </div>
</div>
