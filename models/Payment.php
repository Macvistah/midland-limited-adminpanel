<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_tb".
 *
 * @property int $payment_id
 * @property string $transaction_no
 * @property string $amount
 * @property string $payment_mode
 * @property string $paid_by
 * @property string $created_on
 *
 * @property Order[] $order
 */
class Payment extends \yii\db\ActiveRecord
{
    public $payment_account;
    public $account_no;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'payment_mode', 'paid_by','account_no','payment_account'], 'required'],
            [['created_on',], 'safe'],
            [['transaction_no', 'amount', 'payment_mode', 'paid_by'], 'string', 'max' => 100],
            [['transaction_no'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'payment_id' => 'Payment ID',
            'transaction_no' => 'Transaction No',
            'amount' => 'Amount',
            'payment_mode' => 'Payment Mode',
            'paid_by' => 'Paid By',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasMany(Order::className(), ['payment_id' => 'payment_id']);
    }
}
