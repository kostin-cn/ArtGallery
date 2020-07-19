<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\entities\DeliveryCost;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Стоимость доставки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-cost-index">
        
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
            'cost',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
                                </div>
    </div>
</div>
