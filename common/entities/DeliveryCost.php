<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%delivery_cost}}".
 *
 * @property int $id
 * @property int $cost
 */
class DeliveryCost extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%delivery_cost}}';
    }

    public function rules()
    {
        return [
            [['cost'], 'required'],
            [['cost'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cost' => 'Стоимость доставки',
        ];
    }
}
