<?php

namespace common\entities;

use Yii;
use common\entities\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $city_id
 * @property string $street
 * @property string $house
 * @property string $apartment
 *
 * @property User $user
 */
class UserAddress extends ActiveRecord
{
    const SCENARIO_MACHINE = 'machine';

    public static function tableName()
    {
        return '{{%user_address}}';
    }

    public function scenarios()
    {
        return [
            $this::SCENARIO_MACHINE => ['user_id'],
            $this::SCENARIO_DEFAULT => ['user_id', 'value'],
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'city_id', 'street', 'house', 'apartment'], 'required'],
            [['user_id'], 'integer'],
            [['city_id', 'street', 'house', 'apartment'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'value' => 'Адрес',
            'city_id' => Yii::t('app', 'Город'),
            'street' => Yii::t('app', 'Улица'),
            'house' => Yii::t('app', 'Дом'),
            'apartment' => Yii::t('app', 'Квартира/офис'),
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}