<?php

namespace frontend\forms;

use common\entities\Cities;
use common\entities\OrderItems;
use common\entities\Orders;
use common\models\CartItem;
use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;
use common\models\Cart;
use common\entities\User;

class OrderForm extends Model
{
    public $customer_name;
    public $customer_email;
    public $customer_phone;

    public $address;
    public $city_id;
    public $street;
    public $house;
    public $apartment;

    public $delivery_date;
    public $delivery_time;
    public $note;
    public $payMethod;

    public $verifyCode;
    public $data_collection_checkbox;

    private $cart;

    public function __construct(Cart $cart, $config = [])
    {
        parent::__construct($config);
        $this->cart = $cart;
        if (!Yii::$app->user->isGuest) {
            /* @var $user User */
            $user = Yii::$app->user->identity;

            $this->customer_name = $user->userProfile->getFullName();
            $this->customer_email = $user->email;
            $this->customer_phone = $user->phone;

            $this->address = $user->userAddresses[0]->value;
            $this->city_id = $user->userAddresses[0]->city_id;
            $this->street = $user->userAddresses[0]->street;
            $this->house = $user->userAddresses[0]->house;
            $this->apartment = $user->userAddresses[0]->apartment;
        }
    }

    public function rules()
    {
        return [
            [['address', 'note', 'customer_name'], 'filter', 'filter' => function ($value) {
                return HtmlPurifier::process($value);
            }],
            [['note'], 'string'],
            [['payMethod', 'customer_name', 'customer_phone', 'customer_email', 'city_id', 'street', 'house', 'apartment'], 'required'],
            [['customer_name', 'customer_email', 'address', 'street', 'house', 'apartment'], 'string', 'max' => 255],
            [['customer_phone', 'delivery_date', 'delivery_time'], 'string', 'max' => 20],
            [['city_id'], 'integer'],

            ['verifyCode', 'captcha', 'captchaAction' => 'site/captcha', 'on' => 'create'],
            [['data_collection_checkbox'], 'required', 'requiredValue' => 1, 'message' => Yii::t('app', 'Your Approve Required'),],
        ];
    }

    public function attributeLabels()
    {
        return [
            'customer_name' => Yii::t('app', 'Ваше имя'),
            'customer_email' => Yii::t('app', 'E-mail'),
            'customer_phone' => Yii::t('app', 'Телефон'),
            'address' => Yii::t('app', 'Адрес доставки'),
            'city_id' => Yii::t('app', 'Город'),
            'street' => Yii::t('app', 'Улица'),
            'house' => Yii::t('app', 'Дом'),
            'apartment' => Yii::t('app', 'Квартира/офис'),
            'delivery_date' => Yii::t('app', 'Время доставки'),
            'note' => Yii::t('app', 'Комментарий к заказу'),
            'payMethod' => Yii::t('app', 'Способ оплаты'),
            'verifyCode' => Yii::t('app', 'Проверочный код'),
            'data_collection_checkbox' => Yii::t('app', 'Согласие на обработку персональных данных'),
        ];
    }

    public function create()
    {
        $order = new Orders();
        if (!Yii::$app->user->isGuest) {
            /* @var $user User */
            $user = Yii::$app->user->identity;
            $order->user_id = $user->id;
            if (!$user->phone) {
                $user->phone = $this->customer_phone;
                $user->save();
            }
            if (!$user->userAddresses[0]->value) {
                $user->userAddresses[0]->value = $this->address;
                $user->userAddresses[0]->save();
            }
            if (!$user->userAddresses[0]->city_id) {
                $user->userAddresses[0]->city_id = $this->city_id;
                $user->userAddresses[0]->save();
            }
            if (!$user->userAddresses[0]->street) {
                $user->userAddresses[0]->street = $this->street;
                $user->userAddresses[0]->save();
            }
            if (!$user->userAddresses[0]->house) {
                $user->userAddresses[0]->house = $this->house;
                $user->userAddresses[0]->save();
            }
            if (!$user->userAddresses[0]->apartment) {
                $user->userAddresses[0]->apartment = $this->apartment;
                $user->userAddresses[0]->save();
            }
        }
        $order->name = $this->customer_name;
        $order->phone = $this->customer_phone;
        $order->email = $this->customer_email;
        $order->city = Cities::findOne($this->city_id)->title;
        $order->street = $this->street;
        $order->house = $this->house;
        $order->apartment = $this->apartment;

        $order->address = $this->address;

        if ($this->delivery_date) {
            $order->datetime = strtotime($this->delivery_date);
        }

        $order->pay_method = $this->payMethod;
        $order->quantity = $this->cart->getAmount();
        $order->cost = $this->cart->getTotalCost();
        $order->note = $this->note;
        $order->cart_json = $this->cart->setArrayJson($this->cart);
        if ($order->save()) {
            $this->saveOrderItems($this->cart->getItems(), $order->id);
            foreach ($this->cart->getItems() as $item) {
                $product = $item->getProduct();
                $product->status = 2;
                $product->save();
            }
        }
        return $order;
    }

    protected function saveOrderItems($items, $order_id)
    {
        /* @var $item CartItem */
        foreach ($items as $id => $item) {
            $order_item = new OrderItems();
            $order_item->order_id = $order_id;
            $order_item->product_id = $item->getProductId();
            $order_item->title = $item->getProduct()->title;
            $order_item->qty_item = $item->quantity;
            $order_item->price_item = $item->getPrice();
            $order_item->save();
        }
    }

    public function mail($order)
    {
        $this->sendToAdmin($order);
        if ($this->customer_email) {
            $this->sendToCustomer($order);
        }
    }

    private $adminHtml;
    private $customerHtml;


    public function sendToAdmin($order)
    {
        /* @var $order Orders */
        $payMethods = Yii::$app->params['payMethods'];

        $this->adminHtml .= "<style>";
        $this->adminHtml .= ".h2{ font-size:2em; font-weight:lighter; text-transform:uppercase;}";
        $this->adminHtml .= "</style>";
        $this->adminHtml .= "<table>";
        $this->adminHtml .= "<tr><td>Cпособ оплаты</td><td>: {$payMethods[$order->pay_method]}</td></tr>";
        $this->adminHtml .= "<tr><td colspan='2' class='form-heading' ><h2>Клиент</h2></td><td></td></tr>";
        $this->adminHtml .= "<tr><td>Имя</td><td>: {$order->name}</td></tr>";
        $this->adminHtml .= $order->email ? "<tr><td>E-Mail</td><td>: {$order->email}</td></tr>" : null;
        $this->adminHtml .= "<tr><td>Телефон</td><td>: {$order->phone}</td></tr>";
        $this->adminHtml .= "<tr><td>Город</td><td>: {$order->city}</td></tr>";
        $this->adminHtml .= "<tr><td>Улица</td><td>: {$order->street}</td></tr>";
        $this->adminHtml .= "<tr><td>Дом</td><td>: {$order->house}</td></tr>";
        $this->adminHtml .= "<tr><td>Квартира/офис</td><td>: {$order->apartment}</td></tr>";
        $this->adminHtml .= $order->note ? "<tr><td>Комментарии</td><td>: {$order->note}</td></tr>" : null;
        $this->adminHtml .= "</table>";

        $this->adminHtml .= "<h4>Список картин:</h4>";
        $this->adminHtml .= "<table>";
        $this->adminHtml .= "<tr><td>Название</td><td> Количество</td><td> Цена</td></tr>";
        foreach ($order->orderItems as $item) {
            $this->adminHtml .= "<tr><td>{$item->title}</td><td>{$item->qty_item}  шт.</td><td> {$item->price_item} руб.</td></tr>";
        }
        $this->adminHtml .= "<tr><td></td><td></td><td>Итого</td><td>: {$order->cost} руб.</td></tr>";
        $this->adminHtml .= "</table>";

        $sent = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Заказ от ' . $this->customer_name)
            ->setHtmlBody($this->adminHtml)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки E-mail.');
        }
    }

    public function sendToCustomer($order)
    {
        /* @var $order Orders */
        $payMethods = Yii::$app->params['payMethods'];

        $this->customerHtml .= "<style>";
        $this->customerHtml .= ".h2{ font-size:2em; font-weight:lighter; text-transform:uppercase;}";
        $this->customerHtml .= "</style>";
        $this->customerHtml .= "<h2>Ваш заказ принят</h2>";
        $this->customerHtml .= "<table>";
        $this->customerHtml .= "<tr><td>Имя</td><td>: {$order->name}</td></tr>";
        $this->customerHtml .= "<tr><td>Телефон</td><td>: {$order->phone}</td></tr>";
        $this->customerHtml .= "<tr><td>Город</td><td>: {$order->city}</td></tr>";
        $this->customerHtml .= "<tr><td>Улица</td><td>: {$order->street}</td></tr>";
        $this->customerHtml .= "<tr><td>Дом</td><td>: {$order->house}</td></tr>";
        $this->customerHtml .= "<tr><td>Квартира/офис</td><td>: {$order->apartment}</td></tr>";
        $this->customerHtml .= "<tr><td>Cпособ оплаты</td><td>: {$payMethods[$order->pay_method]}</td></tr>";
        $this->customerHtml .= $order->note ? "<tr><td>Комментарии</td><td>: {$order->note}</td></tr>" : null;
        $this->customerHtml .= "</table>";

        $this->customerHtml .= "<h4>Список картин:</h4>";
        $this->customerHtml .= "<table>";
        $this->customerHtml .= "<tr><td>Название</td><td> Количество</td><td> Цена</td></tr>";
        foreach ($order->orderItems as $item) {
            $this->customerHtml .= "<tr><td>{$item->title}</td><td>{$item->qty_item}  шт.</td><td> {$item->price_item} руб.</td></tr>";
        }
        $this->customerHtml .= "<tr><td></td><td>Итого</td><td>: {$order->cost} руб.</td></tr>";
        $this->customerHtml .= "</table>";

        $sent = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo($this->customer_email)
            ->setSubject('Подтверждение заказа с сайта: ' . Yii::$app->name)
            ->setHtmlBody($this->customerHtml)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки E-mail.');
        }
    }
}