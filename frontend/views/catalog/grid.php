<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $form yii\widgets\ActiveForm */
/* @var $searchModel \frontend\forms\FiltersForm */
/* @var $dataProvider \yii\data\ActiveDataProvider */

?>

<div class="filters-block">
    <div class="filters-bg"></div>

    <?php $form = ActiveForm::begin(['action' => ['catalog/grid'], 'method' => 'GET', 'options' => ['id' => 'filters', 'data-pjax' => true],]); ?>
    <div id="filtersContainer">
        <div class="flex-row">
            <?= $form->field($searchModel, 'size')->radioList(
                $searchModel::getSizeVariants(),
                [
                    'unselect' => null,
                    'name' => 'size',
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return $this->render('size_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
                    }
                ]
            ) ?>
            <?= $form->field($searchModel, 'format')->checkboxList($searchModel::getFormatsList(), [
                'unselect' => null,
                'name' => 'format',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return $this->render('format_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
                }
            ]) ?>
            <?= $form->field($searchModel, 'material')->checkboxList($searchModel::getMaterialsList(), [
                'unselect' => null,
                'name' => 'material',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return $this->render('material_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
                }
            ]) ?>
            <?= $form->field($searchModel, 'category')->checkboxList($searchModel::getCategoriesList(), [
                'unselect' => null,
                'name' => 'category',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return $this->render('category_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
                }
            ]) ?>
            <?= $form->field($searchModel, 'color')->checkboxList($searchModel::getColorsList(), [
                'unselect' => null,
                'name' => 'color',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return $this->render('color_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
                }
            ]) ?>
            <?= $form->field($searchModel, 'price')->radioList($searchModel->getPricesList(), [
                'unselect' => null,
                'name' => 'price',
                'item' => function ($index, $label, $name, $checked, $value) {
                    return $this->render('price_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,
                    ]);
                }
            ]) ?>

        </div>
        <?= $form->field($searchModel, 'author')->checkboxList($searchModel::getAuthorsList(), [
            'unselect' => null,
            'name' => 'author',
            'item' => function ($index, $label, $name, $checked, $value) {
                return $this->render('author_box', ['index' => $index, 'value' => $value, 'label' => $label, 'checked' => $checked, 'name' => $name,]);
            }
        ]) ?>
    </div>
    <div class="form-group filters-apply">
        <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'btn-link black']) ?>
    </div>
    <?php ActiveForm::end(); ?>


    <div class="filtersBtns">
        <a class="read-more" href="<?= Url::to(['catalog/grid']); ?>"><?= Yii::t('app', 'Сбросить'); ?></a>
        <div class="read-more close-filters"><span class="close"></span> <?= Yii::t('app', 'Закрыть'); ?></div>
    </div>

</div>


<div class="page catalog sc-catalog">
    <div class="fader"></div>
    <div class="wrapper">

        <div class="title-block ">
            <div class="ctrl-btns">
                <span class="view-btn one-item active">
                    <span></span>
                </span>
                <a href="<?= Url::to(['catalog/index']); ?>" class="view-btn multi-items">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </a>
            </div>

            <div class="page-title">
                <h1>
                    <?= Yii::t('app', 'Каталог'); ?>
                </h1>
                <div class="filter-descr">
                    <span><?= Yii::t('app', 'Показано'); ?> </span>
                    <strong id="dataCount" data-count-prv="<?= sprintf('%02d', $dataProvider->count);?>"><?= $dataProvider->count; ?> <?= Yii::t('app', 'работ');?></strong>
                </div>
            </div>

            <div class="filter-btn white-filter">
                <div class="ico icon-filter">
                </div>
                <span><?= Yii::t('app', 'Фильтр'); ?></span>
            </div>

        </div>


    </div>

    <!--    Single item catalogue-->

    <div class="works-nav">
        <div class="prev-c-item nav-btn"></div>
        <span><?= Yii::t('app', 'Работы'); ?></span>
        <div class="next-c-item nav-btn"></div>
    </div>

    <div class="single-blocks-container">
        <div class="bg-image" style="background-image: url(<?= $dataProvider->models[0]->image ;?>)"></div>
        <div class="item-bg"></div>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'sc-items-container', 'id' => 'products_list'],
            'itemOptions' => ['tag' => false,],
            'summary' => '',
            'itemView' => function ($model, $key, $index) {
                return $this->render('_product', [
                        'product' => $model,
                        'key' => $key,
                        'index' => $index,
                ]);
            },
            'viewParams' => [
                    'count' => $dataProvider->count,
            ],
        ]) ?>

    </div>

    <div id="image_ani_holder">
        <img src="" class="t-image" alt="">
    </div>

    <div class="product-popup">
        <div class="product-pop-content">


        </div>


    </div>

</div>

