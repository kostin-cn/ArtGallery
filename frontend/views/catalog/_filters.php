<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $products \common\entities\Products[] */
/* @var $this yii\web\View */
/* @var $model frontend\forms\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */

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
    '10000' => Yii::t('app', 'Меньше 10 000 <span class="icon-rur"></span>.'),
    '10000-50000' => Yii::t('app', '10 000 <span class="icon-rur"></span>. - 50 000 <span class="icon-rur"></span>.'),
    '50000-100000' => Yii::t('app', '50 000 <span class="icon-rur"></span>. - 100 000 <span class="icon-rur"></span>.'),
    '100000-300000' => Yii::t('app', '100 000 <span class="icon-rur"></span>. - 300 000 <span class="icon-rur"></span>.'),
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

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div id="filtersContainer">
        <div class="flex-row">

            <?= $form->field($model, 'size')->checkboxList($sizeArr, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => '<label class="fltrs-item" for="' . $name . '">' . $label . '</label>',
                    ]);
                },
                'itemOptions' => ['template' => '<div class="item">{input}{label}</div>']
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
    <div class="filtersBtns">
        <?= Html::resetButton(Yii::t('app', 'Сбросить'), ['class' => 'read-more']) ?>
        <div class="read-more close-filters"><span class="close"></span> <?= Yii::t('app', 'Закрыть');?></div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
