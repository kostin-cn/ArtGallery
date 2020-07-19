<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\entities\Products;

/**
 * ProductsSearch represents the model behind the search form of `common\entities\Products`.
 */
class ProductsSearch extends Products
{

    public $price_min;
    public $price_max;

    public function rules()
    {
        return [
            [['id', 'status', 'select', 'price_min', 'price_max', 'in_rent', 'category_id', 'author_id'], 'integer'],
            [['title_ru', 'price_min', 'price_max'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Products::find()->having(['approved' => 1]);

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
            'in_rent' => $this->in_rent,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'select', $this->select])
            ->andFilterWhere(['like', 'author_id', $this->author_id])
            ->andFilterWhere(['>=', 'price', $this->price_min])
            ->andFilterWhere(['<=', 'price', $this->price_max]);

        return $dataProvider;
    }
}
