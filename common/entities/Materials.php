<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%materials}}".
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_en
 * @property int $sort
 *
 * @property ProductMaterials[] $productMaterials
 * @property Products[] $products
 */
class Materials extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%materials}}';
    }

    public function behaviors( ) {
        return [
            [
                'class' => SortableBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['sort'], 'integer'],
            [['title_ru', 'title_en'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'sort' => 'Порядок',
        ];
    }

    public function getProductMaterials()
    {
        return $this->hasMany(ProductMaterials::className(), ['material_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('{{%product_materials}}', ['material_id' => 'id']);
    }

    public function getTitle()
    {
        return $this->getAttr('title');
    }

    private function getAttr($attribute)
    {
        $attr = $attribute . '_' . Yii::$app->language;
        $def_attr = $attribute . '_' . Yii::$app->params['defaultLanguage'];
        return $this->$attr ?: $this->$def_attr;
    }
}
