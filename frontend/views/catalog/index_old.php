<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $products \common\entities\Products[] */
/* @var $category \common\entities\ProductCategories */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\forms\FiltersForm */

$sizeArr = [
    '10х10' => Yii::t('app', 'Маленький'),
    '50х50' => Yii::t('app', 'Средний'),
    '100х100' => Yii::t('app', 'Большой'),
    '200х200' => Yii::t('app', 'Гигантский'),
];
$formatArr = [];
$materialArr = [];
$categoryArr = [];
$colorArr = [
    'черный' => Yii::t('app', 'Черный'),
    'белый' => Yii::t('app', 'Белый'),
    'желтый' => Yii::t('app', 'Желтый'),
    'синий' => Yii::t('app', 'Синий'),
    'зеленый' => Yii::t('app', 'Зеленый'),
    'красный' => Yii::t('app', 'Красный'),
    'фиолетовый' => Yii::t('app', 'Фиолетовый'),
];
$priceArr = [
    '10000' => Yii::t('app', 'Меньше 10 000 ₽.'),
    '10000-50000' => Yii::t('app', '10 000 ₽. - 50 000 ₽.'),
    '50000-100000' => Yii::t('app', '50 000 ₽. - 100 000 ₽.'),
    '100000-300000' => Yii::t('app', '100 000 ₽. - 300 000 ₽.'),
];
$authorArr = [];
$count = 0;

foreach ($products as $product) {

    $count++;

    $formatStatus = 1;
    $materialStatus = 1;
    $categoryStatus = 1;
    $authorStatus = 1;

    foreach ($formatArr as $formatItm) {if ($formatItm == $product->format) {$formatStatus = 0;}}
    foreach ($materialArr as $materialItm) {if ($materialItm == $product->material) {$materialStatus = 0;}}
    foreach ($categoryArr as $categoryItm) {if ($categoryItm == $product->category->title) {$categoryStatus = 0;}}
    foreach ($authorArr as $authorItm) {if ($authorItm == $product->author) {$authorStatus = 0;}}

    if ($formatStatus) {$formatArr[] = $product->format;}
    if ($materialStatus) {$materialArr[] = $product->material;}
    if ($categoryStatus) {$categoryArr[] = $product->category->title;}
    if ($authorStatus) {$authorArr[] = $product->author;}

};

?>

<div class="filters-block">
    <div class="filters-bg"></div>

    <?php $form = ActiveForm::begin(); ?>
    <div id="filtersContainer">
        <div class="flex-row">
            <?= $form->field($model, 'size')->checkboxList($sizeArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>
            <?= $form->field($model, 'format')->checkboxList($formatArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>
            <?= $form->field($model, 'material')->checkboxList($materialArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>
            <?= $form->field($model, 'category')->checkboxList($categoryArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>
            <?= $form->field($model, 'color')->checkboxList($colorArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>
            <?= $form->field($model, 'price')->checkboxList($priceArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
            ]) ?>

        </div>
        <?= $form->field($model, 'author')->checkboxList($authorArr, [
            'item' => function ($index, $label, $name, $checked, $value) {
                return Html::checkbox($name, $checked, [
                    'value' => $value,
                    'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                ]);
            },
        ]) ?>
    </div>
    <div class="form-group hide">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>


    <div class="filtersBtns">
        <a class="read-more" href="#"><?= Yii::t('app', 'Сбросить');?></a>
        <div class="read-more close-filters"><span class="close"></span> <?= Yii::t('app', 'Закрыть');?></div>
    </div>

</div>


<div class="page catalog">
    <div class="fader"></div>
    <div class="wrapper">

        <div class="title-block ">
            <div class="ctrl-btns">
                <span class="view-btn one-item active">
                    <span></span>
                </span>
                <a href="<?= Url::to(['catalog/grid']); ?>" class="view-btn multi-items">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>

            <div class="page-title">
                <h1>
                    <?= Yii::t('app', 'Каталог');?>
                </h1>
                <div class="filter-descr">
                    <span><?= Yii::t('app', 'Показано');?> </span>
                    <strong><?= $count;?> работ</strong>
                </div>
            </div>

            <div class="filter-btn white-filter">
                <div class="ico icon-filter">
                </div>
                <span><?= Yii::t('app', 'Фильтр');?></span>
            </div>

        </div>


    </div>

<!--    Single item catalogue-->

    <div class="works-nav">
        <div class="prev-c-item nav-btn"></div>
        <span><?= Yii::t('app', 'Работы');?></span>
        <div class="next-c-item nav-btn"></div>
    </div>

    <div class="single-blocks-container">
        <div class="bg-image" style="background-image: url(<?= $products[0] ->image ;?>)"></div>
        <div class="item-bg"></div>

        <div class="sc-items-container">
            <?php foreach ($products as $key =>  $product): ; ?>

                <div class="item <?= $key == 0 ? 'active_item' : '' ;?>"
                     data-image="<?= $product->image; ?>"
                     data-size = '<?= $product->size;?>'
                     data-format = '<?= $product->format;?>'
                     data-material = '<?= $product->material;?>'
                     data-category = '<?= $product->category->title;?>'
                     data-price = '<?= $product->price;?>'
                     data-author = '<?= $product->author;?>'
                >

                    <div class="info-side">
                        <div class="pages">
                            <span class="current">
                                <?= sprintf('%02d', $key + 1);?>
                            </span>
                            <span class="separator"></span>
                            <span class="total">
                                <?= sprintf('%02d', count($products));?>
                            </span>
                        </div>

                        <p class="author">
                            <?= $product->author; ?>
                        </p>
                        <h4>
                            <?= $product->title; ?>
                        </h4>

                        <div class="picture-info">
                            <span><?= number_format($product->price, 0, '', ' '); ?> ₽</span>
                        </div>

                        <a href="<?= Url::to(['catalog/menu-item', 'slug' => $product->slug]);?>" class="read-more p-ajax-link">Подробнее</a>

                    </div>
                    <div class="image-side">
                        <img src="<?= $product->image; ?>" alt="<?= $product->title; ?>" class="image">
                    </div>

                </div>

            <?php endforeach; ?>
        </div>

    </div>

    <div id="image_ani_holder">
        <img src="" class="t-image" alt="">
    </div>

    <div class="product-popup">
        <div class="product-pop-content">


        </div>


    </div>

</div>

