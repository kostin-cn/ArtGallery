<?php

namespace common\entities;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $quantity
 * @property int $cost
 * @property int $created_at
 * @property int $updated_at
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $street
 * @property string $house
 * @property string $apartment
 * @property string $phone
 * @property string $datetime
 * @property string $pay_method
 * @property string $note
 * @property string $cart_json
 * @property int $status
 * @property int $user_status
 *
 * @property OrderItems[] $orderItems
 * @property User $user
 */
class Orders extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function behaviors()
    {
        return [
            'class' => TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['name', 'phone', 'city', 'street', 'house', 'apartment'], 'required'],
            [['note', 'datetime', 'cart_json'], 'string'],
            [['phone', 'pay_method'], 'string', 'max' => 20],
            [['name', 'email', 'address', 'city', 'street', 'house', 'apartment'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['cart_json'], 'safe'],
            [['quantity', 'cost'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantity' => 'Количество товаров',
            'cost' => 'Сумма',
            'created_at' => 'Оформлен',
            'updated_at' => 'Обработан',
            'datetime' => 'Время доставки',
            'name' => 'Имя',
            'email' => 'E-mail',
            'phone' => 'Телефон',
            'address' => 'Адрес доставки',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира/офис',
            'note' => 'Комментарии',
            'status' => 'Статус',
            'user_status' => 'Доступно к удалению',
            'pay_method' => 'Способ оплаты',
        ];
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['order_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
