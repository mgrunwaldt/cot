<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Buses;

/**
 * BusesSearch represents the model behind the search form of `app\models\Buses`.
 */
class BusesSearch extends Buses
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number', 'file_id', 'device_id', 'deleted'], 'integer'],
            [['plate', 'created_on', 'updated_on'], 'safe'],
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
        $query = Buses::find();

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
            'number' => $this->number,
            'file_id' => $this->file_id,
            'device_id' => $this->device_id,
            'created_on' => $this->created_on,
            'updated_on' => $this->updated_on,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'plate', $this->plate]);

        return $dataProvider;
    }
}
