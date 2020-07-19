<?php

use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $articles \common\entities\Articles[];
 */
?>

<div class="blog-page">
    <div class="wrapper">
        <h1 class="page-title jq_hidden"><?= Yii::t('app', 'Блог');?></h1>
        <div class="blogContainer">
            <?php foreach ($articles as $article):;?>
                <div class="blogBlock jq_hidden">
                    <div class="img" style="background-image: url('<?= $article->image;?>')"></div>
                    <h3 class="title"><?= $article->title;?></h3>
                    <p class="desc print-text"><?= $article->short_descr;?></p>
                    <p class="date">
                        <span><?= Yii::$app->formatter->asDate($article->date, 'dd MMMM yyyy'); ?></span>
                        <a class="read-more dark" href="<?= Url::to(['/site/article', 'slug' => $article->slug]);?>"><?= Yii::t('app', 'Подробнее');?></a>
                    </p>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>