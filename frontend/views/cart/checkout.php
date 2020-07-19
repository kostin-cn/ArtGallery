<?php

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\components\Service;
use kartik\widgets\DateTimePicker;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View
 * @var $model \frontend\forms\OrderForm
 * @var $form yii\bootstrap\ActiveForm
 * @var $cart \common\models\Cart
 * @var $cities \common\entities\Cities[]
 * @var $deliveryCost \common\entities\DeliveryCost
 * @var $text \common\entities\Modules
 */

$this->title = Yii::t('app', 'оформить заказ');

foreach ($cities as $city) {
    $citiesArr[$city->id] = $city->title;
}
?>

<div id="checkout_index" class="page single-page">

    <?php $form = ActiveForm::begin(['id' => 'checkout-form', 'options' => ['class' => 'styledForm']]); ?>

    <div class="checkoutContainer">

        <div class="checkoutBlock">

            <h1 class="page-title"><?= Yii::t('app', 'Оформление заказа');?></h1>

            <div class="row">

                <div class="col-lg-6">
                    <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'customer_phone')->widget(MaskedInput::class, [
                        'mask' => '+7 (999) 999-99-99',
                    ]) ?>
                    <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'city_id')->dropDownList($citiesArr) ?>
                    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'apartment')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
                    <p>* - <?= Yii::t('app', 'обязательные поля');?></p>
                </div>

                <div class="col-lg-6">

                    <div class="checkout-radio">
                        <?= $form->field($model, 'payMethod')->radioList(Yii::$app->params['payMethods'], [
                            'item' => function ($index, $label, $name, $checked, $value) use ($model) {
                                $ch = $checked ? 'checked' : '';
                                return
                                    '<div class="checkout_pay_input">
                                                  <input type="radio" class="pay_radio" id="pay_method-' . $value . '" name="' . $name . '" value="' . $value . '" ' . $ch . ' />
                                                  <label for="pay_method-' . $value . '">' . $label . '</label>
                                              </div>';
                            }
                        ]) ?>
                    </div>

                </div>

            </div>

        </div>

        <div class="checkoutBlock">

            <div class="checkout-item">

                <h3 class="block-title"><?= Yii::t('app', 'Ваш заказ');?></h3>

                <div class="cartContainer">
                    <?php foreach ($cart->getItems() as $item):
                    /* @var  $item \common\models\CartItem */
                    $product = $item->getProduct();
                    $url = Url::to(['catalog/item', 'slug' => $product->slug]);?>
                    <div class="cartBlock">

                        <a class="image-block" href="<?= $url;?>">
                            <img src="<?= $product->image;?>" alt="">
                        </a>

                        <div class="info-block">
                            <p class="author"><?= $product->author ? $product->author : $product->authorName;?></p>
                            <a class="title" href="<?= $url;?>"><?= $product->title ?></a>
                            <p class="price"><?= number_format($product->price, 0, '', ' ');?> <span class="icon-rur"></span></p>
                        </div>

                    </div>
                    <?php endforeach;?>
                </div>

            </div>

            <div class="checkout-item">

                <h3 class="block-title"><?= Yii::t('app', 'Итого');?></h3>
                <p class="block-total"><span><?= Yii::t('app', 'Стоимость заказа');?>:</span><strong><?= number_format($cart->getCost(), 0, '', ' '); ?> <span class="icon-rur"></span></strong></p>
                <p class="block-total"><span><?= Yii::t('app', 'Стоимость доставки');?>:</span><strong><?= $deliveryCost->cost; ?> <span class="icon-rur"></span></strong></p>
                <p class="block-total"><span><?= Yii::t('app', 'Итого сумма');?>:</span><strong><?= number_format($cart->getCost() + $deliveryCost->cost, 0, '', ' '); ?> <span class="icon-rur"></span></strong></p>

                <?= $form->field($model, 'data_collection_checkbox', [
                    'options' => ['class' => 'form-group data-checkbox'],
                    'checkboxTemplate' => "{input}{label}\n{hint}\n{error}"
                ])->checkbox(); ?>

                <?php if (Yii::$app->user->isGuest): ; ?>
                    <div class="captcha">
                        <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                            'captchaAction' => 'site/captcha',
                            'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-7">{input}</div></div>',
                        ]) ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('app', 'оформить заказ'), ['class' => 'btn-link wide']) ?>
                </div>

            </div>

            <div class="checkout-item wide print-text">
                <h3><?= $text->title;?></h3>
                <?= $text->html;?>
                <a class="read-more" href="<?= Url::to(['/catalog/index']);?>"><?= Yii::t('app', 'вернуться в каталог');?></a>
            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>