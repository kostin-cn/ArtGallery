<?php

use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $header \common\entities\Modules;
 * @var $abouts \common\entities\Abouts[];
 */
?>
<div class="headerBlock respons__block" style="background-image: url('<?= $header->image;?>')">
    <div class="headerText">
        <h1><?= $header->title;?></h1>
        <div class="desc">
            <?= $header->html;?>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="aboutContainer">
        <?php foreach ($abouts as $about):;?>
        <div class="aboutBlock">
            <div class="text jq_hidden">
                <p class="sub-title"><?= $about->sub_title;?></p>
                <h2 class="title"><?= $about->title;?></h2>
                <div class="print-text">
                    <?= $about->html;?>
                </div>
                <div class="aboutButtons">
                    <a href="<?= Url::to(['/site/contacts']);?>"><?= Yii::t('app', 'Связаться с нами');?></a>
                    <a href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'Коллекция картин');?></a>
                </div>
            </div>
            <img class="jq_hidden" src="<?= $about->image;?>" alt="">
        </div>
        <?php endforeach;?>
    </div>
</div>