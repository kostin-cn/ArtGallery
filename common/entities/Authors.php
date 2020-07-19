<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%authors}}".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property int $sort
 * @property int $status
 *
 * @property Products[] $products
 * @property Products[] $activeProducts
 */
class Authors extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%authors}}';
    }

    public function behaviors()
    {
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
            [['sort', 'status'], 'integer'],
            [['title_ru', 'title_en'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Имя Фамилия Ru',
            'title_en' => 'Имя Фамилия En',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(Products::class, ['author_id' => 'id']);
    }

    public function getActiveProducts()
    {
        return $this->hasMany(Products::class, ['author_id' => 'id'])->having(['status' => 1, 'approved' => 1]);
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
