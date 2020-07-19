<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%tariffs}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $period
 * @property integer $price
 * @property integer $price_per_month
 * @property string $html
 * @property string $html_ru
 * @property string $html_en
 * @property integer $sort
 * @property integer $status
 */
class Tariffs extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tariffs}}';
    }

    const VARIANTS = [
        'one' => 'Одна работа',
        'series' => 'Серия работ',
    ];

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
            [['category', 'price'], 'required'],
            [['category'], 'string', 'max' => 50],
            [['period'], 'string', 'max' => 100],
            [['html_ru', 'html_en'], 'string'],
            [['sort', 'price', 'price_per_month'], 'integer'],
            [['status'], 'integer', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'period' => 'Период',
            'price' => 'Стоимость',
            'price_per_month' => 'Цена в месяц',
            'html_ru' => 'Описание Ru',
            'html_en' => 'Описание En',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getHtml()
    {
        return $this->getAttr('html');
    }

    private function getAttr($attribute)
    {
        $attr = $attribute . '_' . Yii::$app->language;
        $def_attr = $attribute . '_' . Yii::$app->params['defaultLanguage'];
        return $this->$attr ?: $this->$def_attr;
    }
}