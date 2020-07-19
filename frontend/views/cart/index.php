<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\components\Service;

/* @var $this yii\web\View */
/* @var $cart \common\models\Cart */

$count = Yii::$container->get(Cart::class)->getAmount();
?>

<div id="cart-page" data-count="<?= $count;?>">
    <div class="cartContainer">
        <h2><?= Yii::t('app', 'Корзина') ?></h2>
        <?php if (!$cart->getItems()) {;?>
            <p>
                <span><?= Yii::t('app', 'тут пусто, но никогда не поздно');?></span>
                <a href="<?= Url::to(['/catalog/index']);?>" style="text-decoration: underline"><?= Yii::t('app', 'это&nbsp;исправить');?></a>
            </p>
        <?php }else{
            foreach ($cart->getItems() as $item):
                /* @var  $item \common\models\CartItem */
                $product = $item->getProduct();
                $url = Url::to(['catalog/item', 'slug' => $product->slug]);?>
            <div class="cartBlock">
                <div class="cartRemove" data-href="<?= Url::to(['/cart/remove', 'id' => $item->getId()]); ?>">
                    <span class="icon-delete"></span>
                </div>
                <a class="image-block" href="<?= $url;?>">
                    <img src="<?= $product->image;?>" alt="">
                </a>
                <div class="info-block">
                    <p class="author"><?= $product->author ? $product->author : $product->authorName;?></p>
                    <a class="title" href="<?= $url;?>"><?= $product->title ?></a>
                    <p class="price"><?= number_format($product->price, 0, '', ' ');?> <span class="icon-rur"></span></p>
                </div>
            </div>
        <?php endforeach;};?>
    </div>
    <?php if ($cart->getItems()) {;?>
        <div class="cartTotal">
            <div class="cost-total">
                <span><?= Yii::t('app', 'Итого');?>: </span>
                <span><?= number_format($cart->getCost(), 0, '', ' '); ?> <span class="icon-rur"></span></span>
            </div>
            <?php if ($cart->getItems()): ?>
                <a class="read-more white" href="<?= Url::to(['cart/checkout']) ?>"><?= Yii::t('app', 'оформить заказ');?></a>
            <?php endif; ?>
        </div>
    <?php };?>
</div>