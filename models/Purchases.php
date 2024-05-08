<?php

namespace app\models;


/**
 * This is the model class for table "purchases_tb".
 *
 * @property int $id
 * @property int $prod_id
 * @property int $supplier_id
 * @property int|null $original_qty
 * @property int|null $available_qty
 * @property string|null $description
 * @property string|null $payment_code
 * @property string|null $purchase_no
 * @property string $status
 * @property float $price_per_unit
 * @property float $discount
 * @property float $final_price_per_unit
 * @property string $create_on
 */
class Purchases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prod_id', 'supplier_id', 'original_qty', 'price_per_unit'], 'required'],
            [['prod_id', 'supplier_id'], 'integer'],
            [['description', 'status'], 'string'],
            [['price_per_unit', 'discount', 'final_price_per_unit'], 'number'],
            [['create_on'], 'safe'],
            [['payment_code', 'purchase_no'], 'string', 'max' => 10],
            [['price_per_unit'], 'validatePrice']
        ];
    }

    public function validatePrice($attribute,$params){
        $product = Product::findOne($this->prod_id);
        if ($product){
            if ($this->price_per_unit > $product->price){
                $this->addError($attribute,"Price should not exceed {$product->price}");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prod_id' => 'Prod ID',
            'supplier_id' => 'Supplier ID',
            'original_qty' => 'Original Qty',
            'available_qty' => 'Available Qty',
            'description' => 'Description',
            'payment_code' => 'Payment Code',
            'purchase_no' => 'Purchase No',
            'status' => 'Status',
            'price_per_unit' => 'Price Per Unit',
            'discount' => 'Discount',
            'final_price_per_unit' => 'Final Price Per Unit',
            'create_on' => 'Purchase Date',

        ];
    }

}
