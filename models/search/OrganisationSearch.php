<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organisation;

/**
 * OrganisationSearch represents the model behind the search form of `app\models\Organisation`.
 */
class OrganisationSearch extends Organisation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['char_code', 'name_ru', 'name_kk', 'report_acrual_date'], 'safe'],
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
        $query = Organisation::find();

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
            'report_acrual_date' => $this->report_acrual_date,
        ]);

        $query->andFilterWhere(['ilike', 'char_code', $this->char_code])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_kk', $this->name_kk]);

        return $dataProvider;
    }
}
