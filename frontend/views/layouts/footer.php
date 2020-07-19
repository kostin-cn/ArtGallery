<?php

/* @var $socials \common\entities\Socials[];
 * @var $email \common\entities\Contacts[];
 * @var $phone \common\entities\Contacts[];
 * @var $footerMenuItems array;
 */

use yii\helpers\Url;
use yii\widgets\Menu;
?>

<div id="footer">
    <div id="footer-black-border"></div>
    <div class="wrapper">
        <div class="footerBlock footerNav">
            <a class="logo" href="<?= Url::to(['site/index']); ?>">
                <span class="icon-logo"></span>
            </a>
            <?= Menu::widget([
                'items' => $footerMenuItems,
                'options' => ['id' => 'footerNavMenu', 'class' => 'navMenu navigation'],
            ]); ?>
            <div class="socials">
                <?php foreach ($socials as $social):;?>
                    <a class="soc" href="<?= $social->link;?>" target="_blank">
                        <span class="icon-<?= $social->icon;?>"></span>
                    </a>
                <?php endforeach;?>
            </div>
        </div>
        <div class="footerBlock">
            <img src="/files/payment/robokassa.svg" alt="">
            <img src="/files/payment/visa.png" alt="">
            <img src="/files/payment/mastercard.svg" alt="">
        </div>
        <div class="footerBlock">
            <?php foreach ($email as $item):;?>
                <?= $this->render('/site/_email',["item" => $item->value]);?>
            <?php endforeach;?>
            <span class="divider">|</span>
            <?php foreach ($phone as $item):;?>
                <a href="tel:<?= str_replace([' ', '(', ')'], '', $item->value); ?>"><?= $item->value; ?></a>
            <?php endforeach;?>
        </div>
        <div class="footerBlock">
            <span>Made by creative connection</span>
        </div>
    </div>
</div>
