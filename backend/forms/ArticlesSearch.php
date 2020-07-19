<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\entities\Articles;

/**
 * ArticlesSearch represents the model behind the search form of `common\entities\Articles`.
 */
class ArticlesSearch extends Articles
{
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title_ru', 'date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Articles::find();

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
            ->andFilterWhere(['>=', 'date', $this->date ? strtotime($this->date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'date', $this->date ? strtotime($this->date . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
