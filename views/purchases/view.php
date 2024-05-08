<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Purchases */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Purchases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$product = \app\models\Product::findOne($model->prod_id);
$supplier = \app\models\Supplier::findOne($model->supplier_id);
?>
<div class="purchases-view">
    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute'=>'prod_id',
                        'label'=>'Product',
                        'format'=>'raw',
                        'value'=> $product->prod_name ,
                    ],
                    [
                        'attribute'=>'supplier_id',
                        'label'=>'Supplier',
                        'format'=>'raw',
                        'value'=> $supplier->contact_fname.' '. $supplier->contact_sname,
                    ],
                    [
                        'attribute'=>'original_qty',
                        'label'=>'Quantity',
                    ],
                    [
                        'attribute'=>'original_qty',
                        'label'=>'Price per unit',
                    ],
                    [
                        'attribute'=>'status',
                        'label'=>'Purchase Status',
                    ],
                    'description',
                    [
                        'attribute'=>'create_on',
                        'label'=>'Purchase Date',
                        'format'=> 'date'
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>
