<?php

use yii\helpers\Url;

/* @var $product \common\entities\Products */
?>
<div class="page product no-scroll">
    <div id="ajax_content">

        <div class="product-item">
            <div class="info-side">
                <p class="author">
                    <?= $product->author ? $product->author : $product->authorName; ?>
                </p>
                <h2>
                    <?= $product->title; ?>
                </h2>

                <div class="price">
                    <span><?= number_format($product->price, 0, '', ' '); ?> <span class="icon-rur"></span></span>
                </div>

                <div class="picture-info">
                    <div class="info-block">
                        <strong>
                            <?= Yii::t('app', 'Размер');?>:
                        </strong>
                        <span><?= $product->width; ?> x <?= $product->height; ?> <?= Yii::t('app', 'см');?></span>
                    </div>
                    <div class="info-block">
                        <strong>
                            <?= Yii::t('app', 'Материал');?>:
                        </strong>
                        <?php if ($product->materials){;?>
                            <?php foreach ($product->materials as $material):;?>
                                <span><?= $material->title;?> ,</span>
                            <?php endforeach;?>
                        <?php }else {;?>
                            <span><?= $product->material;?></span>
                        <?php };?>
                    </div>
                    <div class="info-block">
                        <strong>
                            <?= Yii::t('app', 'Формат');?>:
                        </strong>
                         <?= $product->format->title;?>

                    </div>
                    <div class="info-block">
                        <strong>
                            <?= Yii::t('app', 'Жанр');?>:
                        </strong>
                         <?= $product->category->title;?>
                    </div>

                </div>

                <?php if ($product->description) {;?>
                    <div class="descr-block">
                        <h4>
                            <?= Yii::t('app', 'Описание');?>
                        </h4>
                        <?= $product->description;?>
                    </div>
                <?php };?>

                <div class="p-ctrl-btns">
                    <div class="p-ctrl-btn fullscreen-btn p-t-ctrl-btn">
                        <span class="ico icon-fullscreen"></span>
                        <span><?= Yii::t('app', 'На весь экран');?></span>
                    </div>
                    <div class="p-ctrl-btn interior-btn p-t-ctrl-btn">
                        <span class="ico icon-interior"></span>
                        <span><?= Yii::t('app', 'В интерьере');?></span>
                    </div>
                    <div id="buyProduct" class="p-ctrl-btn p-t-ctrl-btn" data-href="<?= Url::to(['cart/plus', 'id' => $product->id]); ?>">
                        <span class="ico icon-buy"></span>
                        <span><?= Yii::t('app', 'Купить');?></span>
                    </div>
                    <div id="rentProduct" class="p-ctrl-btn p-t-ctrl-btn" data-href="<?= Url::to(['catalog/rent', 'slug' => $product->slug]); ?>">
                        <span class="ico icon-rent"></span>
                        <span><?= Yii::t('app', 'Арендовать');?></span>
                    </div>

                </div>
                <a href="<?= Url::to(['catalog/index', 'slug' => $product->category->slug]); ?>" class="read-more p-pop-close"><?= Yii::t('app', 'Назад к работам');?></a>


            </div>
            <div class="image-side int-image-cont">
                <img id="viewer_image" src="<?= $product->image; ?>" alt="<?= $product->title; ?>" class="image">
            </div>

        </div>

        <div class="interior-popup">
            <div class="int-pop-close">
                <span></span>
                <span></span>
            </div>
            <div class="room-block" style="background: #dfdbd8 url(https://d1ycxz9plii3tb.cloudfront.net/misc/room.jpg) bottom center no-repeat; "></div>

        </div>
    </div>
</div>
