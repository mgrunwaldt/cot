<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Logs;

/**
 * LogsSearch represents the model behind the search form of `app\models\Logs`.
 */
class LogsSearch extends Logs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'administrator_id', 'user_id', 'provider_id'], 'integer'],
            [['text', 'ip', 'browser', 'date'], 'safe'],
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
        $query = Logs::find();

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
            'administrator_id' => $this->administrator_id,
            'user_id' => $this->user_id,
            'provider_id' => $this->provider_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'browser', $this->browser]);

        return $dataProvider;
    }
}
