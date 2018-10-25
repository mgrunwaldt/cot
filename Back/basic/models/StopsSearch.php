<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Stops;

/**
 * StopsSearch represents the model behind the search form of `app\models\Stops`.
 */
class StopsSearch extends Stops
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'stop_type', 'deleted'], 'integer'],
            [['name', 'short_name', 'arriving_text', 'arrived_text', 'leaving_text', 'created_on', 'updated_on'], 'safe'],
            [['latitude', 'longitude'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Stops::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'stop_type' => $this->stop_type,
            'created_on' => $this->created_on,
            'updated_on' => $this->updated_on,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'arriving_text', $this->arriving_text])
            ->andFilterWhere(['like', 'arrived_text', $this->arrived_text])
            ->andFilterWhere(['like', 'leaving_text', $this->leaving_text]);

        return $dataProvider;
    }
}
