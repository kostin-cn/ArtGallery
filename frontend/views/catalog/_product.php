<?php

use yii\helpers\Url;
use frontend\components\Service;

/* @var $product \common\entities\Products */
?>

<div class="item <?= $index == 0 ? 'active_item' : '' ;?>" data-image="<?= $product->image; ?>">
    <div class="info-side">

        <div class="pages">
            <span class="current">
                <?= sprintf('%02d', $index + 1);?>
            </span>
            <span class="separator"></span>
            <span class="total dataCountBlock">
                <?= sprintf('%02d', $count);?>
            </span>
        </div>

        <p class="author">
            <?= $product->author ? $product->author : $product->authorName; ?>
        </p>
        <h4>
            <?= $product->title; ?>
        </h4>

        <div class="picture-info">
            <span><?= Service::formatPrice($product->price); ?></span>
        </div>

        <a href="<?= Url::to(['catalog/item', 'slug' => $product->slug]); ?>"
           class="read-more p-ajax-link"><?= Yii::t('app', 'Подробнее');?></a>

    </div>
    <div class="image-side">
        <img src="<?= $product->image; ?>" alt="<?= $product->title; ?>" class="image">
    </div>
</div>