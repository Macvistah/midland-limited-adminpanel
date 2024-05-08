<?php
// components/ProductSelectInput.php
namespace app\components;

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

class ProductSelectInput extends Select2
{
    // Customize this method to format the options as needed
    public function init()
    {
        parent::init();

        // Example data for demonstration purposes
        $data = [
            1 => ['id' => 1, 'name' => 'Product 1', 'quantity' => 10, 'image' => 'product1.jpg'],
            2 => ['id' => 2, 'name' => 'Product 2', 'quantity' => 5, 'image' => 'product2.jpg'],
            // Add more products here
        ];

        $options = ArrayHelper::map($data, 'id', function ($item) {
            return [
                'data-name' => $item['name'],
                'data-quantity' => $item['quantity'],
                'data-image' => $item['image'],
            ];
        });

        $this->data = $options;
        $this->options = ['placeholder' => 'Select a product...'] + $this->options;
    }
}
