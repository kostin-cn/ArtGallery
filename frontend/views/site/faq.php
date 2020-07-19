<?php

use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $articles \common\entities\Faq[];
 */
?>

<div class="faq-page">
        <h1 class="page-title jq_hidden"><?= Yii::t('app', 'Частые вопросы');?></h1>
        <div class="faqContainer grid">
            <?php foreach ($articles as $article):;?>
                <div class="faqBlock jq_hidden grid-item">
                    <h3 class="title"><?= $article->title;?></h3>
                    <div class="desc print-text"><?= $article->html;?></div>
                </div>
            <?php endforeach;?>
        </div>
</div>