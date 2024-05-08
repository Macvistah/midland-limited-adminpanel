<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Purchases;

/**
 * PurchasesSearch represents the model behind the search form of `app\models\Purchases`.
 */
class PurchasesSearch extends Purchases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prod_id', 'supplier_id', 'original_qty', 'available_qty'], 'integer'],
            [['description', 'payment_code', 'purchase_no', 'status', 'create_on'], 'safe'],
            [['price_per_unit', 'discount', 'final_price_per_unit'], 'number'],
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
        $query = Purchases::find();

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
            'prod_id' => $this->prod_id,
            'supplier_id' => $this->supplier_id,
            'original_qty' => $this->original_qty,
            'available_qty' => $this->available_qty,
            'price_per_unit' => $this->price_per_unit,
            'discount' => $this->discount,
            'final_price_per_unit' => $this->final_price_per_unit,
            'create_on' => $this->create_on,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'payment_code', $this->payment_code])
            ->andFilterWhere(['like', 'purchase_no', $this->purchase_no])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
