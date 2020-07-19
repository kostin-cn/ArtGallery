<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use backend\components\SortableBehavior;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%product_categories}}".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $slug
 * @property int $sort
 * @property int $status
 *
 * @property Products[] $products
 */
class ProductCategories extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%product_categories}}';
    }

    public function behaviors( ) {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title_ru',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ],
            [
                'class' => SortableBehavior::class,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title_ru'], 'required'],
            [['sort', 'status'], 'integer'],
            [['title_ru', 'title_en', 'slug'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'slug' => 'Slug',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(Products::class, ['category_id' => 'id']);
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
