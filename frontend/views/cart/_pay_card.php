<?php

/* @var $this yii\web\View
 * @var $cart \common\models\Cart
 * @var $deliveryCost \common\entities\DeliveryCost
 */

;?>

<div class="site-request-password-reset personal h-80">
    <div class="wrapper">

        <h1 class="page-title"><?= Yii::t('app', 'Выберите способ оплаты');?></h1>

        <?
        $mrh_login = "in-n-art.com";
        $mrh_pass1 = "Aa121314";
        $inv_id = $id;
        $inv_desc = "Картины";
        $out_summ = $cart->getCost() + $deliveryCost->cost;
        $IsTest = 1;
        $crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
        print "<html><script language=JavaScript ".
            "src='https://auth.robokassa.ru/Merchant/PaymentForm/FormMS.js?".
            "MerchantLogin=$mrh_login&OutSum=$out_summ&InvoiceID=$inv_id".
            "&Description=$inv_desc&SignatureValue=$crc&IsTest=$IsTest'></script></html>";
        ?>

    </div>
</div>