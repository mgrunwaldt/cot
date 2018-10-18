<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Administrators;

/**
 * AdministratorsSearch represents the model behind the search form of `app\models\Administrators`.
 */
class AdministratorsSearch extends Administrators
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'administrator_role_id', 'administrator_file_id', 'active', 'deleted'], 'integer'],
            [['email', 'password', 'name', 'last_name', 'phone', 'created_on', 'updated_on'], 'safe'],
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
        $query = Administrators::find();

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
            'administrator_role_id' => $this->administrator_role_id,
            'administrator_file_id' => $this->administrator_file_id,
            'active' => $this->active,
            'created_on' => $this->created_on,
            'updated_on' => $this->updated_on,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
