<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\SelectPrice;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Select Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="select-price-index">
        
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

                            'id',
            'min',
            'max',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
                                </div>
    </div>
</div>
