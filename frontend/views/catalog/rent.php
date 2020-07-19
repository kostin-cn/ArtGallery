<?php

use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\forms\RentForm */
/* @var $tariffs \common\entities\Tariffs[] */

$this->title = Yii::t('app', 'Арендовать');
$this->params['breadcrumbs'][] = $this->title;

foreach ($tariffs as $tariff) {
    $tariffsArr[$tariff->id] = $tariff->period .' - '. number_format($tariff->price, 0, '', ' ') . ' руб.';
}
?>
<div class="site-rent">
    <div class="wrapper">
        <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'rent-form']); ?>

        <?= $form->field($model, 'tariff_id')->dropDownList($tariffsArr) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Оформить аренду'), ['class' => 'btn-link black wide', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
