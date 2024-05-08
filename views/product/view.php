<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Product View';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title">View Product </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                        [
                                                'attribute'=>'image',
                                                'format'=>'raw',
                                                'value'=>function($data){
                                                    if ($data->image!=null){
                                                        return "<img src='../../uploads/product_images/".$data->image."'  style='max-width:20%' >";
                                                    }else{
                                                        return "No Image";
                                                    }
                                                },

                                        ],
                                    'prod_name',
                                    [
                                            'attribute'=>'category_id',
                                            'value'=>function($data){
                                                $modelCategory = \app\models\ProductCategory::findOne(['id'=>$data->category_id]);
                                                if($modelCategory){
                                                    return $modelCategory->name;
                                                }
                                                else{
                                                    return '-';
                                                }
                                            }
                                    ],
                                    'qty',
                                    [
                                            'attribute'=>'price',
                                            'label'=>'Unit Price (Ksh)',
                                            'format'=>['decimal',2]
                                    ],
                                    [
                                        'attribute'=>'discount',
                                        'label'=>'Discount (%)',
                                        'format'=>['decimal',2],
                                    ],
                                    [
                                        'label'=>'Discount Amount(Ksh)',
                                        'format'=>['decimal',2],
                                        'value'=>$model->discount/100* $model->price,
                                    ],
                                    [
                                        'label'=>'Final Price(Ksh)',
                                        'format'=>['decimal',2],
                                        'value'=>$model->price - ($model->discount/100* $model->price),
                                    ],
                                    'description:ntext',
                                    'created_on:date',
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <p class="pull-right">
                        <?= Html::a('Update', ['update', 'id' => $model->prod_id], ['class' => 'btn btn-success']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>



</div>
