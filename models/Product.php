<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_tb".
 *
 * @property int $prod_id
 * @property string $prod_name
 * @property int $category_id
 * @property int $qty
 * @property float $price
 * @property float $discount
 * @property string $description
 * @property string $image
 * @property string $created_on
 */
class Product extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prod_name', 'category_id', 'qty', 'price',], 'required'],
            [['category_id', 'qty'], 'integer'],
            [['price','discount'], 'number'],
            [['file'],'file'],
            [['description'], 'string'],
            [['created_on','file'], 'safe'],
            [['prod_name', 'image'], 'string', 'max' => 100],
            [['prod_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prod_id' => 'Prod ID',
            'prod_name' => 'Product Name',
            'category_id' => 'Product Category',
            'qty' => 'Qty',
            'price' => 'Unit Price',
            'discount' => 'Discount',
            'description' => 'Description',
            'image' => 'Product Image',
            'file'=>'Image',
            'created_on' => 'Created On',
        ];
    }
}
