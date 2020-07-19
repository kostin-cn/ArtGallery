<?php

use yii\helpers\Url;

/* @var $cart array */
/* @var $id int */
/* @var $sum int */
?>

<div class="cart-page">
    <div class="cartContainer">
        <h2><?= Yii::t('app', 'Заказ') ?></h2>
        <?php if (!empty($cart)) {
        foreach ($cart as $item): ;?>
        <div class="cartBlock">
            <div class="image-block">
                <img src="<?= $item['image'];?>" alt="">
            </div>
            <div class="info-block">
                <p class="author"><?= $item['author'];?></p>
                <span class="title"><?= $item['title'] ?></span>
                <p class="price"><?= number_format($item['cost'], 0, '', ' ');?> <span class="icon-rur"></span></p>
            </div>
        </div>
        <?php endforeach;};?>
    </div>
    <?php if (!empty($cart)) {;?>
        <div class="cartTotal">
            <div class="cost-total">
                <span><?= Yii::t('app', 'Итого');?>: </span>
                <span><?= number_format($sum, 0, '', ' '); ?> <span class="icon-rur"></span></span>
            </div>
        </div>
    <?php };?>
</div>
