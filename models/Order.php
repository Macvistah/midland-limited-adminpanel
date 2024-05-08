<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_tb".
 *
 * @property int $id
 * @property string $order_no
 * @property int $user_id
 * @property string|null $payment_id
 * @property float $shipping_charge
 * @property float $total_amount
 * @property string $order_date
 * @property string $status
 *
 * @property OrderDetails[] $orderDetails
 * @property ShippingDetails[] $shippingDetails
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_no', 'user_id', 'shipping_charge', 'total_amount', 'status'], 'required'],
            [['user_id'], 'integer'],
            [['shipping_charge', 'total_amount'], 'number'],
            [['order_date'], 'safe'],
            [['order_no', 'payment_id', 'status'], 'string', 'max' => 100],
            [['order_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'user_id' => 'User ID',
            'payment_id' => 'Payment Code',
            'shipping_charge' => 'Shipping Charge',
            'total_amount' => 'Total Amount',
            'order_date' => 'Order Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[ShippingDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShippingDetails()
    {
        return $this->hasMany(ShippingDetails::className(), ['order_id' => 'id']);
    }
}
