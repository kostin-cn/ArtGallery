<?php


use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $ones \common\entities\Tariffs[];
 * @var $series \common\entities\Tariffs[];
 */
?>

<div class="tariffs-page">

    <?php if ($ones):;?>
        <h2 class="page-title jq_hidden"><span><?= Yii::t('app', 'Аренда');?></span><span> <?= Yii::t('app', 'одной работы');?></span></h2>
        <div class="tariffsContainer">
            <?php foreach ($ones as $one):;?>
                <div class="tariffsBlock jq_hidden">
                    <p class="period"><?= $one->period;?></p>
                    <h3 class="price"><?= number_format($one->price, 0, '', ' ');?> <span class="icon-rur"></span></h3>
                    <p class="price_per_month"><?= number_format($one->price_per_month, 0, '', ' ');?> <span class="icon-rur"></span> в месяц</p>
                    <div class="desc">
                        <?= $one->html;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <p class="txtCenter jq_hidden"><a class="block-btn" href="<?= Url::to('/catalog/index');?>"><?= Yii::t('app', 'Перейти в каталог');?></a></p>
    <?php endif;?>
    <?php if ($series):;?>
        <h2 class="page-title jq_hidden"><span><?= Yii::t('app', 'Аренда');?></span><span> <?= Yii::t('app', 'серии работ');?></span></h2>
        <div class="tariffsContainer">
            <?php foreach ($series as $sr):;?>
                <div class="tariffsBlock jq_hidden">
                    <p class="period"><?= $sr->period;?></p>
                    <h3 class="price"><?= number_format($sr->price, 0, '', ' ');?> <span class="icon-rur"></span></h3>
                    <p class="price_per_month"><?= number_format($sr->price_per_month, 0, '', ' ');?> <span class="icon-rur"></span> в месяц</p>
                    <div class="desc">
                        <?= $sr->html;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <p class="txtCenter"><a class="block-btn" href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'Перейти в каталог');?></a></p>
    <?php endif;?>
</div>