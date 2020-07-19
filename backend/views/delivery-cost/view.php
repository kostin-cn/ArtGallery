<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\entities\DeliveryCost;

/* @var $this yii\web\View */
/* @var $model common\entities\DeliveryCost */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Стоимость доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-cost-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' =>
        'btn btn-primary']) ?>

    </p>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'cost',
                        ],
                    ]) ?>
                </div>
            </div>

        </div>
    </div>
</div>
