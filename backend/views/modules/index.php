<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\Modules;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модули';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modules-index">

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
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
                    'title_ru',

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
