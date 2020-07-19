<?php

use yii\helpers\Url;
use yii\widgets\Menu;
use common\widgets\MultiLang\MultiLang;
use common\models\Cart;

/* @var $menuItems array */

$count = Yii::$container->get(Cart::class)->getAmount();
?>
<div id="black-border"></div>
<div class="wrapper">
    <a class="logo" href="<?= Url::to(['site/index']); ?>">
        <span class="icon-logo"></span>
    </a>

    <!--    --><?//= MultiLang::widget(); ?>
    <?= Menu::widget([
        'items' => $menuItems,
        'options' => ['id' => 'mainNavMenu', 'class' => 'navMenu navigation'],
    ]); ?>
    <div class="userNav">
        <?= MultiLang::widget(); ?>
        <?php if (Yii::$app->user->isGuest) {;?>
            <div id="mainUser" class="mainUser" data-href="<?= Url::to(['/site/login']);?>"><span class="icon-user"></span></div>
        <?php }else{;?>
            <a id="mainAccount" href="<?= Url::to(['/account/index']);?>"><span class="icon-user"></span></a>
        <?php };?>
        <div id="mainCart" data-href="<?= Url::to(['/cart/index']);?>">
            <span class="icon-cart"></span>
            <?php if ($count) {;?>
                <span id="mainCount" class='count show'><?= $count;?></span>
            <?php }else {;?>
                <span id="mainCount" class='count'></span>
            <?php };?>
        </div>
        <div id="toggleMode" data-href="<?= Url::to(['/site/set-cookie']);?>"><span>w</span><span>b</span></div>
        <div id="menu_button">
            <div class="burger">
                <span></span>
                <span class="mid"></span>
                <span class="mid"></span>
                <span></span>
            </div>
        </div>
    </div>
</div>
