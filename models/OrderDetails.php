<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property int $id
 * @property int $order_id
 * @property int $prod_id
 * @property int $qty
 * @property float $price
 * @property string $specifications
 *
 * @property OrderTb $order
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'prod_id', 'qty', 'price', 'specifications'], 'required'],
            [['order_id', 'prod_id', 'qty'], 'integer'],
            [['price'], 'number'],
            [['specifications'], 'string'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderTb::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'prod_id' => 'Prod ID',
            'qty' => 'Qty',
            'price' => 'Price',
            'specifications' => 'Specifications',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(OrderTb::className(), ['id' => 'order_id']);
    }
}
