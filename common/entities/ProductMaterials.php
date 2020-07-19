<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_materials}}".
 *
 * @property int $material_id
 * @property int $product_id
 *
 * @property Materials $material
 * @property Products $product
 */
class ProductMaterials extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_materials}}';
    }

    public function rules()
    {
        return [
            [['material_id', 'product_id'], 'required'],
            [['material_id', 'product_id'], 'integer'],
            [['material_id', 'product_id'], 'unique', 'targetAttribute' => ['material_id', 'product_id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Materials::className(), 'targetAttribute' => ['material_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'material_id' => 'Material ID',
            'product_id' => 'Product ID',
        ];
    }

    public function getMaterial()
    {
        return $this->hasOne(Materials::className(), ['id' => 'material_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
