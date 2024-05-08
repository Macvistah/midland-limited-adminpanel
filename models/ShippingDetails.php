<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shipping_details".
 *
 * @property int $id
 * @property int $order_id
 * @property string $full_name
 * @property string $phone_no
 * @property string $location
 * @property int|null $driver_id
 * @property string|null $delivery_date
 *
 * @property Order $order
 */
class ShippingDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shipping_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'full_name', 'phone_no', 'location'], 'required'],
            [['order_id', 'driver_id'], 'integer'],
            [['location'], 'string'],
            [['delivery_date'], 'safe'],
            [['full_name'], 'string', 'max' => 255],
            [['phone_no'], 'string', 'max' => 100],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order No',
            'full_name' => 'Full Name',
            'phone_no' => 'Phone No',
            'location' => 'Location',
            'driver_id' => 'Driver Name',
            'delivery_date' => 'Delivery Date',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
