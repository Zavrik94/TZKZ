<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arrear;

/**
 * ArrearSearch represents the model behind the search form of `app\models\Arrear`.
 */
class ArrearSearch extends Arrear
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_iin_bin', 'organisation_char_code', 'bcc', 'bcc_name_ru', 'bcc_name_kz'], 'safe'],
            [['tax_arrear', 'poena_arrear', 'percent_arrear', 'fine_arrear', 'total_arrear'], 'number'],
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
        $query = Arrear::find();
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
            'tax_arrear' => $this->tax_arrear,
            'poena_arrear' => $this->poena_arrear,
            'percent_arrear' => $this->percent_arrear,
            'fine_arrear' => $this->fine_arrear,
            'total_arrear' => $this->total_arrear,
        ]);

        $query->andFilterWhere(['ilike', 'user_iin_bin', $this->user_iin_bin])
            ->andFilterWhere(['ilike', 'organisation_char_code', $this->organisation_char_code])
            ->andFilterWhere(['ilike', 'bcc', $this->bcc])
            ->andFilterWhere(['ilike', 'bcc_name_ru', $this->bcc_name_ru])
            ->andFilterWhere(['ilike', 'bcc_name_kz', $this->bcc_name_kz]);


        return $dataProvider;
    }
}
