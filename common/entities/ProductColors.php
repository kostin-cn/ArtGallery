<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_colors}}".
 *
 * @property int $color_id
 * @property int $product_id
 *
 * @property Colors $color
 * @property Products $product
 */
class ProductColors extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_colors}}';
    }

    public function rules()
    {
        return [
            [['color_id', 'product_id'], 'required'],
            [['color_id', 'product_id'], 'integer'],
            [['color_id', 'product_id'], 'unique', 'targetAttribute' => ['color_id', 'product_id']],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'color_id' => 'Color ID',
            'product_id' => 'Product ID',
        ];
    }

    public function getColor()
    {
        return $this->hasOne(Colors::className(), ['id' => 'color_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
