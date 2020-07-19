<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%select_price}}".
 *
 * @property int $id
 * @property int $min
 * @property int $max
 */
class SelectPrice extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%select_price}}';
    }

    public function rules()
    {
        return [
            [['min', 'max'], 'required'],
            [['min', 'max'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min' => 'Минимум',
            'max' => 'Максимум',
        ];
    }
}
