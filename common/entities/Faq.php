<?php

namespace common\entities;

use Yii;
use yii\db\ActiveRecord;
use backend\components\SortableBehavior;

/**
 * This is the model class for table "{{%faq}}".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $html
 * @property string $html_ru
 * @property string $html_en
 * @property int $sort
 * @property int $status
 *
 */
class Faq extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%faq}}';
    }


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
            [['html_ru', 'html_en'], 'string'],
            [['title_ru', 'title_en'], 'string', 'max' => 100],
            [['sort', 'status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'html_ru' => 'Текст Ru',
            'html_en' => 'Текст En',
            'sort' => 'Порядок',
            'status' => 'Статус',
        ];
    }

    public function getTitle()
    {
        return $this->getAttr('title');
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
