<?php

namespace frontend\controllers;

use common\entities\Cities;
use common\entities\DeliveryCost;
use common\entities\Modules;
use common\entities\OrderItems;
use common\entities\Orders;
use frontend\forms\OrderForm;
use Yii;
use yii\base\Module;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use common\models\Cart;
use common\models\CartItem;
use common\entities\Products;
use frontend\components\FrontendController;

class CartController extends FrontendController
{
    /* @var $cart Cart */
    private $cart;

    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cart = Yii::$container->get('common\models\Cart');
    }

    public function actionIndex()
    {
//        if (!$this->cart->getItems()) {
//            Yii::$app->session->setFlash('error', 'Корзина пуста.');
//            return $this->redirect(['catalog/index']);
//        }
        return $this->renderAjax('index', [
            'cart' => $this->cart,
        ]);
    }

    public function actionAdd()
    {
        $post = Yii::$app->request->post();
        $quantity = $post['quantity-input'] ?: $post['quantity'];
        $menu_item = Products::findOne($post['id']);
        $cart_item = new CartItem($menu_item, $quantity);
        $this->cart->add($cart_item);
        Yii::$app->session->setFlash('success', Yii::t('app', 'Добавлено в корзину.'));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPlus($id)
    {
        if (!$product = Products::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        $cart_item = new CartItem($product, 1);
        $this->cart->add($cart_item);

        return $this->renderAjax('index', [
            'cart' => $this->cart,
        ]);
    }

    public function actionMinus($id)
    {
        if (!$product = Products::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        if (!$this->cart->getItem($id)) {
            return false;
        }
        $cart_item = new CartItem($product, -1);
        $this->cart->add($cart_item);
        if (!$item = $this->cart->getItem($id)) {
            return $this->renderAjax('ajax_cart', [
                'data' => $product,
                'quantity' => null,
                'message' => Yii::t('app', 'Удалено из корзины.')
            ]);
        }

        $data = $item->getProduct();
        $qty = $item->getQuantity();

        return $this->renderAjax('ajax_cart', [
            'data' => $data,
            'quantity' => $qty,
            'message' => Yii::t('app', 'Изменено количество.')
        ]);
    }


    public function actionUpdate($id, $inc)
    {
        /* @var $item CartItem */
        foreach ($this->cart->getItems() as $item) {
            if ($item->getId() == $id) {
                $quantity = $item->getQuantity() + $inc;
                if ($quantity < 1) {
                    $this->cart->remove($id);
                } else {
                    $this->cart->set($id, $quantity);
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemove($id)
    {
        $this->cart->remove($id);

        return $this->renderAjax('index', [
            'cart' => $this->cart,
        ]);
    }

    public function actionClear()
    {
        $this->cart->clear();

        return $this->redirect(['catalog/index']);
    }

    public function actionReorder($id)
    {
        if (!$oldOrder = Orders::findOne($id)) {
            throw new NotFoundHttpException(Yii::t('app', 'Запрошенная вами страница не существует.'));
        }
        $message = null;
        foreach ($oldOrder->orderItems as $item) {
            if ($product = Products::findOne(['id' => $item->product_id, 'category_status' => 1, 'status' => 1])) {
                $cartItem = new CartItem($product, $item->qty_item);
                $this->cart->add($cartItem);
            } else {
                $message .= $item->title . ' ' . Yii::t('app', 'больше недоступен для заказа') . '<br>';
            }
        }
        return $this->redirect(['checkout', 'message' => $message]);
    }

    public function actionCheckout($message = null)
    {
        $cities = Cities::find()->having(['status' => 1])->orderBy(['sort' => SORT_ASC])->all();
        $text = Modules::findOne(5);
        $deliveryCost = DeliveryCost::findOne(1);
        $id = Orders::find()->orderBy(['id' => SORT_DESC])->one()->id + 1;
        if (!$this->cart->getItems()) {
            Yii::$app->session->setFlash('error', $message . Yii::t('app', 'Корзина пуста.'));
            return $this->redirect(['catalog/index']);
        }
        if ($message) {
            Yii::$app->session->setFlash('error', $message);
        }
        $form = new OrderForm($this->cart);
        if (Yii::$app->user->isGuest) {
            $form->scenario = 'create';
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            if ($form->payMethod == 'card') {

                $cookies = Yii::$app->response->cookies;
                $cookies->add(new Cookie(['name' => 'innart_name', 'value' => $form->customer_name]));
                $cookies->add(new Cookie(['name' => 'innart_phone', 'value' => $form->customer_phone]));
                $cookies->add(new Cookie(['name' => 'innart_email', 'value' => $form->customer_email]));
                $cookies->add(new Cookie(['name' => 'innart_city', 'value' => $form->city_id]));
                $cookies->add(new Cookie(['name' => 'innart_street', 'value' => $form->street]));
                $cookies->add(new Cookie(['name' => 'innart_house', 'value' => $form->house]));
                $cookies->add(new Cookie(['name' => 'innart_apartment', 'value' => $form->apartment]));
                $cookies->add(new Cookie(['name' => 'innart_note', 'value' => $form->note]));

                return $this->render('_pay_card', [
                    'cart' => $this->cart,
                    'deliveryCost' => $deliveryCost,
                    'id' => $id
                ]);
            }else {
                if ($order = $form->create()) {
                    try {
                        $form->mail($order);
                    } catch (\RuntimeException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                    Yii::$app->session->setFlash('success', Yii::t('app', 'Спасибо за ваш заказ'));
                    $this->cart->clear();
                    return $this->redirect(['site/index']);
                }
            }
        }
        return $this->render('checkout', [
            'cart' => $this->cart,
            'model' => $form,
            'cities' => $cities,
            'text' => $text,
            'deliveryCost' => $deliveryCost,
        ]);
    }

    public function actionPayCard($report = null)
    {
        return $report;
    }

    public function actionSuccess()
    {
        $form = new OrderForm($this->cart);

        $cookies = Yii::$app->request->cookies;
        $form->payMethod = 'card';
        $form->customer_name = $cookies->getValue('innart_name', 'пусто');
        $form->customer_phone = $cookies->getValue('innart_phone', 'пусто');
        $form->customer_email = $cookies->getValue('innart_email', 'пусто');
        $form->city_id = $cookies->getValue('innart_city', 'пусто');
        $form->street = $cookies->getValue('innart_street', 'пусто');
        $form->house = $cookies->getValue('innart_house', 'пусто');
        $form->apartment = $cookies->getValue('innart_apartment', 'пусто');
        $form->note = $cookies->getValue('innart_note', 'пусто');

        if ($order = $form->create()) {
            try {
                $form->mail($order);
            } catch (\RuntimeException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            Yii::$app->session->setFlash('success', Yii::t('app', 'Спасибо за ваш заказ'));
            $this->cart->clear();
            return $this->redirect(['site/index']);
        }
    }

    public function actionFail()
    {
        Yii::$app->session->setFlash('error', Yii::t('app', 'Ошибка оплаты'));
        return $this->redirect(['cart/checkout']);
    }
}