<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%rent}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $tariff_id
 * @property int $per_month
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 * @property int $status
 *
 * @property Products $product
 * @property Tariffs $tariff
 * @property User $user
 */
class Rent extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%rent}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => null,
            ]
        ];
    }

    public function rules()
    {
        return [
            [['tariff_id'], 'required'],
            [['user_id', 'product_id', 'tariff_id', 'per_month', 'created_at', 'status'], 'integer'],
            [['date'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            [['tariff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tariffs::class, 'targetAttribute' => ['tariff_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'tariff_id' => 'Tariff ID',
            'per_month' => 'В месяц',
            'date' => 'Аренда до',
            'created_at' => 'Created At',
            'status' => 'Статус',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    public function getTariff()
    {
        return $this->hasOne(Tariffs::class, ['id' => 'tariff_id']);
    }

}
