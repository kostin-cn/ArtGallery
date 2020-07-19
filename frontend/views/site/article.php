<?php

use yii\helpers\Url;
use common\entities\Socials;

/* @var $this yii\web\View
 * @var $article \common\entities\Articles;
 * @var $twitter \common\entities\Socials;
 * @var $facebook \common\entities\Socials;
 */

$twitter = Socials::find()->where(['icon' => 'tw'])->having(['status' => 1])->one();
$facebook = Socials::find()->where(['icon' => 'fb'])->having(['status' => 1])->one();
?>

<div class="wrapper">
    <div class="articleContainer">
        <p class="date"><span><?= Yii::$app->formatter->asDate($article->date, 'dd MMMM yyyy'); ?></span></p>
        <div class="title">
            <h1><?= $article->title;?></h1>
            <div class="socials">
                <?php if ($twitter):;?>
                    <a href="<?= $twitter->link;?>" target="_blank"><span class="icon-tw"></span></a>
                <?php endif;?>
                <?php if ($facebook):;?>
                    <a href="<?= $facebook->link;?>" target="_blank"><span class="icon-fb"></span></a>
                <?php endif;?>
            </div>
        </div>
        <?= $article->description;?>
        <a class="read-more" href="<?= Url::to(['/site/blog']);?>"><?= Yii::t('app', 'Назад к статьям');?></a>
    </div>
</div>
