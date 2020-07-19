<?php

namespace common\entities;

use Yii;
use \yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%colors}}".
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_en
 * @property int $sort
 *
 * @property ProductColors[] $productColors
 * @property Products[] $products
 */
class Colors extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%colors}}';
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

    public function getProductColors()
    {
        return $this->hasMany(ProductColors::className(), ['color_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('{{%product_colors}}', ['color_id' => 'id']);
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
