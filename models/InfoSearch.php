<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Info;

/**
 * InfoSearch represents the model behind the search form of `app\models\Info`.
 */
class InfoSearch extends Info
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['iin_bin', 'name_ru', 'name_kk', 'send_time'], 'safe'],
            [['total_arrear', 'total_tax_arrear', 'pension_contribution_arrear', 'social_contribution_arrear', 'social_health_insurance_arrear'], 'number'],
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
        $query = Info::find();

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
            'total_arrear' => $this->total_arrear,
            'total_tax_arrear' => $this->total_tax_arrear,
            'pension_contribution_arrear' => $this->pension_contribution_arrear,
            'social_contribution_arrear' => $this->social_contribution_arrear,
            'social_health_insurance_arrear' => $this->social_health_insurance_arrear,
            'send_time' => $this->send_time,
        ]);

        $query->andFilterWhere(['ilike', 'iin_bin', $this->iin_bin])
            ->andFilterWhere(['ilike', 'name_ru', $this->name_ru])
            ->andFilterWhere(['ilike', 'name_kk', $this->name_kk]);

        return $dataProvider;
    }
}
