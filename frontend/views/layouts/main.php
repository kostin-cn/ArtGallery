<?php

use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\entities\Socials;
use common\entities\Contacts;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$cookies = Yii::$app->request->cookies;

$socials = Socials::getDb()->cache(function () {
    return Socials::find()->having(['status' => 1])->orderBy('sort')->all();
}, Yii::$app->params['cacheTime']);
$email = Contacts::getDb()->cache(function () {
    return Contacts::find()->having(['status' => 1])->andWhere(['type' => 'envelope'])->orderBy(['sort' => SORT_ASC])->all();
}, Yii::$app->params['cacheTime']);
$phone = Contacts::getDb()->cache(function () {
    return Contacts::find()->having(['status' => 1])->andWhere(['type' => 'phone'])->orderBy(['sort' => SORT_ASC])->all();
}, Yii::$app->params['cacheTime']);

$menuItems = [
    ['label' => Yii::t('app', 'Каталог'), 'url' => ['catalog/index']],
    ['label' => Yii::t('app', 'Тарифы'), 'url' => ['site/tariffs']],
    ['label' => Yii::t('app', 'Faq'), 'url' => ['site/faq']],
    ['label' => Yii::t('app', 'Предложить работу'), 'url' => ['site/offer']],
    ['label' => Yii::t('app', 'Блог'), 'url' => ['site/blog']],
];
$footerMenuItems = [
    ['label' => Yii::t('app', 'Главная'), 'url' => ['site/index']],
    ['label' => Yii::t('app', 'О галерее'), 'url' => ['site/about']],
    ['label' => Yii::t('app', 'Каталог работ'), 'url' => ['catalog/index']],
//    ['label' => Yii::t('app', 'Художники'), 'url' => ['catalog/index']],
    ['label' => Yii::t('app', 'Тарифы'), 'url' => ['site/tariffs']],
    ['label' => Yii::t('app', 'Faq'), 'url' => ['site/faq']],
    ['label' => Yii::t('app', 'Предложить работу'), 'url' => ['site/offer']],
    ['label' => Yii::t('app', 'Блог'), 'url' => ['site/blog']],
];

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="body-<?= Yii::$app->controller->action->id;?> <?= $cookies->has('innart_dark') ? 'body-dark' : '';?> <?= Yii::$app->devicedetect->isMobile()?"iphone-mode":"";?>">
<?php $this->beginBody() ?>
<div id="main">
    <?= Alert::widget() ?>

    <div id="content" class="contentWrapper">
        <div id="mainNav">
            <?= $this->render('mainNav', [
                'menuItems' => $menuItems,
            ]); ?>
        </div>
        <?= $content ?>
    </div>

    <?= $this->render('footer', [
        'footerMenuItems' => $footerMenuItems,
        'socials' => $socials,
        'email' => $email,
        'phone' => $phone,
    ]); ?>
</div>
<div id="pop-up">
    <div id="close-popUp">
        <span></span>
        <span></span>
    </div>
    <div id="popUpContent">

    </div>
</div>
<div id="loginPopUp">
    <div id="close-loginPopUp" class="read-more white">
        <span class="cross"></span>
        <span><?= Yii::t('app', 'Закрыть');?></span>
    </div>
    <div id="loginContent">

    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
