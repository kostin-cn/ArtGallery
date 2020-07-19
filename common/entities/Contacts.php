<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%contacts}}".
 *
 * @property int $id
 * @property string $type
 * @property string $value
 * @property string $value_ru
 * @property string $value_en
 * @property int $sort
 * @property int $status
 */
class Contacts extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%contacts}}';
    }

    const VARIANTS = [
        'phone' => 'Телефон',
        'envelope' => 'Почта',
        'point' => 'Адрес',
        'clock' => 'Время работы',
        'other' => 'Другое',
    ];

    public function behaviors()
    {
        return [
            [
                'class' => SortableBehavior::class,
//                'scope' => function () {
//                }
            ],
        ];
    }

    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value_ru', 'value_en'], 'string'],
            [['sort', 'status'], 'integer'],
            [['type'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип данных',
            'value_ru' => 'Значение Ru',
            'value_en' => 'Значение En',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getValue()
    {
        return $this->getAttr('value');
    }

    private function getAttr($attribute)
    {
        $attr = $attribute . '_' . Yii::$app->language;
        $def_attr = $attribute . '_' . Yii::$app->params['defaultLanguage'];
        return $this->$attr ?: $this->$def_attr;
    }
}
