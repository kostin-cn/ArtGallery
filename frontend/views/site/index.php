<?php

use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $header \common\entities\Modules;
 * @var $img_cat \common\entities\Modules;
 * @var $slider \common\entities\Slider[];
 * @var $categories \common\entities\ProductCategories[];
 * @var $best_products \common\entities\Products[];
 * @var $new_products \common\entities\Products[];
 * @var $all_products \common\entities\Products[];
 */

?>

<div class="index-bg" style="background-image: url('<?= $img_cat->image;?>')"></div>
<section>
    <div id="indexSlider">
        <?php foreach ($slider as $slide):;?>
            <div class="slide respons__block" style="background-image: url('<?= $slide->image;?>')">
                <div class="slideText">
                    <h2><?= $slide->title;?></h2>
                    <div class="desc">
                        <?= $slide->html;?>
                    </div>
                    <a class="read-more white underlined" href="<?= $slide->link;?>"><?= $slide->link_text;?></a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</section>
<section id="indexText" class="sectionBlock">
    <div class="wrapper">
        <?php if ($header->title){;?>
            <h1 class="jq_hidden"><?= $header->title;?></h1>
        <?php };?>
        <?php if ($header->html){;?>
            <div class="desc jq_hidden">
                <?= $header->html;?>
            </div>
        <?php };?>
        <?php if ($header->link){;?>
            <a class="read-more jq_hidden underlined" href="<?= $header->link;?>"><?= $header->link_text;?></a>
        <?php };?>
    </div>
</section>
<section id="indexCurators" class="sectionBlock">
    <div class="wrapper">
        <div class="sectionTitle">
            <h2 class="jq_hidden"><?= Yii::t('app', 'Выбор наших кураторов');?></h2>
            <a class="all-works jq_hidden" href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'Все работы');?></a>
        </div>
        <div class="sectionSlider jq_hidden">
            <?php foreach ($best_products as $product):;?>
            <div class="slide">
                <a href="<?= Url::to(['catalog/item', 'slug' => $product->slug]);?>">
                    <img src="<?= $product->image;?>" alt="">
                </a>
                <div class="text">
                    <p class="author"><?= $product->author;?></p>
                    <h4 class="title"><?= $product->title;?></h4>
                    <p class="size"><?= $product->width;?> x <?= $product->height;?> <?= Yii::t('app', 'см');?></p>
                    <p class="price"><?= $product->price;?> <span class="icon-rur"></span></p>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</section>
<section id="indexNew" class="sectionBlock">
    <div class="wrapper">
        <div class="sectionTitle jq_hidden">
            <h2><?= Yii::t('app', 'Новые работы');?></h2>
            <a class="all-works" href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'Все работы');?></a>
        </div>
        <div class="sectionSlider jq_hidden">
            <?php foreach ($new_products as $product):;?>
                <div class="slide">
                    <a href="<?= Url::to(['catalog/item', 'slug' => $product->slug]);?>">
                        <img src="<?= $product->image;?>" alt="">
                    </a>
                    <div class="text">
                        <p class="author"><?= $product->author;?></p>
                        <h4 class="title"><?= $product->title;?></h4>
                        <p class="size"><?= $product->width;?> x <?= $product->height;?> <?= Yii::t('app', 'см');?></p>
                        <p class="price"><?= $product->price;?> <span class="icon-rur"></span></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>

<section id="indexCategories" class="sectionBlock">
    <div class="wrapper">
        <div class="sectionTitle jq_hidden">
            <h2><?= Yii::t('app', 'Работы по категориям');?></h2>
        </div>
        <div class="sectionCategories">
            <?php foreach ($categories as $category):;?>
                <a class="catBlock jq_hidden" href="<?= Url::to(['/catalog/index', 'slug' => $category->slug]);?>">
                    <?= $category->title;?>
                </a>
            <?php endforeach;?>
        </div>
    </div>
</section>

<section id="indexCatImg">

</section>

<section id="indexAuthors" class="sectionBlock">
    <div class="wrapper">
        <div class="sectionTitle jq_hidden">
            <h2><?= Yii::t('app', 'Популярные художники');?></h2>
            <a class="all-works" href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'Все художники');?></a>
        </div>
        <div class="sectionSlider jq_hidden">
            <?php
            $authorArr = [];
            foreach ($all_products as $product):
            $status = 0;
            foreach ($authorArr as $key=>$item) {
                if ($item['author'] == $product->author ? $product->author : $product->authorName) {
                    $authorArr[$key]['count']++;
                    $status = 1;
                }
            }
            if (!$status) {
                $authorArr[] = [
                        'author' => $product->author ? $product->author : $product->authorName,
                    'count' => 1,
                    'image' => $product->image,
                ];
            }
            endforeach;?>
            <?php foreach ($authorArr as $auth):;?>
                <div class="slide">
                    <img src="<?= $auth['image'];?>" alt="">
                    <div class="text">
                        <h4 class="title"><?= $auth['author'];?></h4>
                        <p class="size"><?= Yii::t('app', 'продается');?> <?= $auth['count'];?> <?= Yii::t('app', 'работ');?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</section>

<div id="loader">
    <div class="logoContainer">
        <div class="logo">
            <span class="icon-logo"></span>
        </div>
        <div class="logo logo-fill">
            <span class="icon-logo"></span>
        </div>
    </div>
    <div class="lineContainer">
        <div class="loader-line"><span></span></div>
        <div class="loader-line loader-line-fill"><span></span></div>
    </div>
</div>