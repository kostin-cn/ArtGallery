<?php

use yii\helpers\Url;
use frontend\components\Service;

/* @var $product \common\entities\Products */
?>

<div class="item grid-item">
    <div class="jq_hidden">
        <p class="author">
            <?= $product->author ? $product->author : $product->authorName; ?>
        </p>
        <h4>
            <?php
            $title_text = explode(" ",$product->title);

            foreach ($title_text as $w): ?>
                <span><?=  $w;?></span>
            <?php endforeach; ?>
        </h4>

        <div class="picture-info">
            <span><?= $product->width; ?> x <?= $product->height; ?> <?= Yii::t('app', 'см');?> |</span>
            <span><?= Service::formatPrice($product->price); ?></span>
        </div>
    </div>
    <a href="<?= Url::to(['catalog/item', 'slug' => $product->slug]);?>" class="p-ajax-link image-holder jq_hidden">

        <img src="<?= $product->image; ?>" alt="<?= $product->title; ?>" class="image">
    </a>
</div>