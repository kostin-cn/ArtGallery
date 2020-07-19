<?php

namespace frontend\forms;

use common\entities\Materials;
use common\entities\SelectPrice;
use frontend\components\Service;
use Yii;
use yii\base\Model;
use common\entities\Products;
use common\entities\ProductCategories;
use common\entities\Colors;
use common\entities\Authors;
use common\entities\Formats;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class FiltersForm extends Model
{
    public $author;
    public $format;
    public $material;
    public $category;
    public $color;
    public $price;
    public $size;

    public function rules()
    {
        return [
            [['size', 'format', 'material', 'category', 'color', 'price', 'author'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'size' => Yii::t('app', 'Размер'),
            'format' => Yii::t('app', 'Формат'),
            'material' => Yii::t('app', 'Материал'),
            'category' => Yii::t('app', 'Жанр'),
            'color' => Yii::t('app', 'Цвет'),
            'price' => Yii::t('app', 'Цена'),
            'author' => Yii::t('app', 'Автор'),
        ];
    }

    const SIZE_VALUES = [
        'small' => [0, 1000],
        'medium' => [1001, 10000],
        'large' => [10001, 100000],
        'giant' => [100001, 99999999999],
    ];

    public static function getSizeVariants()
    {
        return [
            'small' => Yii::t('app', 'Маленький'),
            'medium' => Yii::t('app', 'Средний'),
            'large' => Yii::t('app', 'Большой'),
            'giant' => Yii::t('app', 'Гигантский'),
        ];
    }

    public static function getAuthorsList()
    {
        return ArrayHelper::map(Authors::find()->orderBy('sort')->having(['status' => 1])->all(), 'id', 'title_ru');
    }

    public static function getCategoriesList()
    {
        return ArrayHelper::map(ProductCategories::find()->orderBy('sort')->having(['status' => 1])->all(), 'slug', 'title_ru');
    }

    public static function getFormatsList()
    {
        return ArrayHelper::map(Formats::find()->orderBy('sort')->having(['status' => 1])->all(), 'id', 'title_ru');
    }

    public static function getMaterialsList()
    {
        return ArrayHelper::map(Materials::find()->orderBy('sort')->all(), 'id', 'title_ru');
    }

    public static function getColorsList()
    {
        return ArrayHelper::map(Colors::find()->orderBy('sort')->having(['status' => 1])->all(), 'id', 'title_ru');
    }

    private function getPricesValues()
    {
        /* @var $models SelectPrice[] */
        $values = [];
        $models = SelectPrice::find()->orderBy('min')->all();
        foreach ($models as $model) {
            $values[$model->id] = $model;
        }
        return $values;
    }

    public function getPricesList()
    {
        /* @var $model SelectPrice */
        $values = [];
        foreach ($this->getPricesValues() as $model) {
            if ($model->min == 0) {
                $values[$model->id] = Yii::t('app', 'Меньше ') . Service::formatPrice($model->max);
            } else {
                $values[$model->id] = Service::formatPrice($model->min) . ' - ' . Service::formatPrice($model->max);
            }
        }

        return $values;
    }

    public function search($params)
    {
        $query = Products::find()->alias('p');
        $query->having(['status' => 1, 'approved' => 1, 'in_rent' => 0]);
        $query->joinWith(['productColors pc'], false);
        $query->joinWith(['productMaterials pm'], false);
        $query->joinWith(['category c'], false);
        $query->groupBy('p.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => [
                    'price' => [
                        'asc' => ['price' => SORT_ASC],
                        'desc' => ['price' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                    'id' => [
                        'asc' => ['id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'default' => SORT_ASC,
                    ],
                ]
            ],
        ]);

        if (!$params) return $dataProvider;

        $this->load($params, '');

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if ($this->author) {
            $query->andWhere(['author_id' => $this->author]);
        }

        if ($this->category) {
            $query->andWhere(['c.slug' => $this->category]);
        }

        if ($this->format) {
            $query->andWhere(['format_id' => $this->format]);
        }

        if ($this->material) {
            $query->andWhere(['pm.material_id' => $this->material]);
        }

        if ($this->color) {
            $query->andWhere(['pc.color_id' => $this->color]);
        }

        if ($this->price) {
            $min = $this->getPricesValues()[$this->price]->min;
            $max = $this->getPricesValues()[$this->price]->max;
            $query->andFilterCompare('p.price', $min, '>=');
            $query->andFilterCompare('p.price', $max, '<=');
        }

        if ($this->size) {
            $min = self::SIZE_VALUES[$this->size][0];
            $max = self::SIZE_VALUES[$this->size][1];
            $query->andFilterCompare('p.square', $min, '>=');
            $query->andFilterCompare('p.square', $max, '<=');
        }

        return $dataProvider;
    }


}