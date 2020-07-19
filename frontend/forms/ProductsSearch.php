<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\entities\Products;

/**
 * ProductsSearch represents the model behind the search form of Products.
 */
class ProductsSearch extends Products
{
    public function rules()
    {
        return [
            [['id', 'priceMin', 'priceMax', 'sizeMin', 'sizeMax', 'category_id'], 'integer'],
            [['size', 'format', 'material_ru', 'author_ru'], 'safe'],
        ];
    }

    public $sizeMin;
    public $sizeMax;
    public $priceMin;
    public $priceMax;

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Products::find()->having(['status'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'author_ru', $this->author_ru])
            ->andFilterWhere(['like', 'format_ru', $this->format_ru])
            ->andFilterWhere(['like', 'material_ru', $this->material_ru])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['>=', 'size', $this->sizeMin])
            ->andFilterWhere(['<=', 'size', $this->sizeMax])
            ->andFilterWhere(['>=', 'price', $this->priceMin])
            ->andFilterWhere(['<=', 'price', $this->priceMax]);

        return $dataProvider;
    }
}
