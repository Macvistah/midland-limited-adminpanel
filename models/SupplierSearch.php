<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'national_id'], 'integer'],
            [['contact_fname', 'contact_sname', 'contact_gender', 'contact_phone', 'company_name', 'contact_email', 'location', 'kra_pin', 'created_on'], 'safe'],
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
        $query = Supplier::find();

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
            'national_id' => $this->national_id,
            'created_on' => $this->created_on,
        ]);

        $query->andFilterWhere(['like', 'contact_fname', $this->contact_fname])
            ->andFilterWhere(['like', 'contact_sname', $this->contact_sname])
            ->andFilterWhere(['like', 'contact_gender', $this->contact_gender])
            ->andFilterWhere(['like', 'contact_phone', $this->contact_phone])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'contact_email', $this->contact_email])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'kra_pin', $this->kra_pin]);

        return $dataProvider;
    }
}
