<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \frontend\forms\AccountForm */
/* @var $cities \common\entities\Cities[] */
/* @var $user \common\entities\User */

$user = Yii::$app->user->identity;

foreach ($cities as $city) {
    $citiesArr[$city->id] = $city->title;
}
?>

<div class="page personal personal-account">

    <?php $form = ActiveForm::begin(); ?>
    <div class="flex-row">
        <div class="info-block">
            <div class="info-block-title">
                <h1 class="page-title"><?= Yii::t('app', 'Личный кабинет');?></h1>
                <div class="link-holder">
                    <a href="<?= Url::to(['account/logout']); ?>" data-method="POST" class="all-works"><?= Yii::t('app', 'Выход');?></a>
                </div>
            </div>
            <div class="personal-info">
                <h2 class="block-title"><?= Yii::t('app', 'Личные данные');?></h2>
                <div class="row">
                    <div class="col-lg-6">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeHolder' => Yii::t('app', 'Имя')]) ?>

                        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                            'mask' => '+7 (999) 999-99-99',
                        ]) ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeHolder' => Yii::t('app', 'Введите E-mail')]) ?>
                    </div>
                </div>

                <div class="add-address-block">
                    <?php if (count($model->addresses) == 1): ; ?>
                        <h2 class="block-title"><?= Yii::t('app', 'Адрес доставки');?></h2>
                    <?php else: ; ?>
                        <h2 class="block-title"><?= Yii::t('app', 'Адреса доставки');?></h2>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php foreach ($model->addresses as $i => $address): ; ?>
                                <?= $form->field($address, '[' . $i . ']city_id')->dropDownList($citiesArr) ?>
                                <?= $form->field($address, '[' . $i . ']street')->textInput(['maxlength' => true, 'placeHolder' => Yii::t('app', 'Введите улицу')]) ?>
                                <?= $form->field($address, '[' . $i . ']house')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($address, '[' . $i . ']apartment')->textInput(['maxlength' => true]) ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!--                    <div class="add-address">-->
                    <!--                        <a href="--><?//= Url::to(['account/add-address']); ?><!--" class="read-more">Добавить другой адрес</a>-->
                    <!--                    </div>-->

                </div>
                <div class="submit-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn-link wide']) ?>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="history">
            <h2 class="block-title"><?= Yii::t('app', 'Мои заказы');?></h2>
            <?php if ($user->activeOrders): ; ?>
                <div class="order-info">
                    <div class="order-item">
                        <div class="item-head item-row">
                            <div class="title">
                                <?= Yii::t('app', 'Дата');?>
                            </div>
                            <div class="count">
                                <?= Yii::t('app', 'Количество товаров');?>
                            </div>
                            <div class="price">
                                <?= Yii::t('app', 'Цена');?>
                            </div>
                            <div class="add-block"></div>
                        </div>
                    </div>
                    <?php foreach ($user->activeOrders as $order): ; ?>
                        <div class="order-item">
                            <div class="item-info item-row">
                                <div class="title">
                                    <?= Yii::$app->formatter->asDate($order->created_at, 'd.MM.yyyy'); ?>
                                </div>
                                <div class="count">
                                    <div class="count-val">
                                        <?= $order->quantity; ?>
                                    </div>
                                </div>
                                <div class="price">
                                    <?= number_format($order->cost, 0, '', ' '); ?> <span class="icon-rur"></span>
                                </div>
                                <div class="add-block">
                                    <a href="<?= Url::to(['account/order-view', 'id' => $order->id]); ?>"
                                       class=" history-link read-more"><?= Yii::t('app', 'Посмотреть&nbsp;заказ');?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="<?= Url::to(['account/clear-history']); ?>" class="clear-btn"><span
                            class="icon-delete"></span> <?= Yii::t('app', 'Очистить список');?> </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="orderPopUp">
    <div id="close-orderPopUp">
        <span></span>
        <span></span>
    </div>
    <div id="orderPopUpContent">

    </div>
</div>