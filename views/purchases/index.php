<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PurchasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Purchases Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchases-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title"><?=$this->title?></h4>
                    <p class="card-category">View all the purchases</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'purchase_no',
                                        [
                                            'attribute'=> 'prod_id',
                                            'label'=>'Product Name',
                                            'format'=> 'raw',
                                            'value'=> function ($data){
                                                $product = \app\models\Product::findOne($data['prod_id']);
                                                if (!$product){
                                                    return '-';
                                                }
                                                return $product->prod_name;
                                            }
                                        ],
                                        [
                                            'attribute'=> 'supplier_id',
                                            'label'=>'Supplier Name',
                                            'format'=> 'raw',
                                            'value'=> function ($data){
                                                $supplier = \app\models\Supplier::findOne($data['supplier_id']);
                                                if (!$supplier){
                                                    return '-';
                                                }
                                                return $supplier->contact_fname.' '.$supplier->contact_sname;
                                            }
                                        ],
                                        'payment_code',
                                        [
                                            'attribute'=>'original_qty',
                                            'format' => ['decimal', 0],
                                            'hAlign'=>'right',
                                        ],
                                        [
                                            'attribute'=>'available_qty',
                                            'format' => ['decimal', 0],
                                            'hAlign'=>'right',
                                        ],
                                        [
                                            'attribute'=>'price_per_unit',
                                            'format' => ['decimal', 2],
                                            'hAlign'=>'right',
                                        ],
                                        [
                                            'width'=>'15%',
                                            'attribute' => 'status',
                                            'filterType' => GridView::FILTER_SELECT2,
                                            'filter' => [
                                                "pending"=>"PENDING",
                                                "approved"=>"APPROVED",
                                                "completed" => "COMPLETED",
                                                "cancelled" => "CANCELLED",
                                            ],
                                            'filterWidgetOptions' => [
                                                'hideSearch' => true,
                                                'pluginOptions' => ['allowClear' => true],
                                            ],
                                            'filterInputOptions' => ['prompt' => '-- All Status --', 'multiple' => false], // allows multiple authors to be chosen
                                            'format' => 'raw',
                                            'value' => function ($data){
                                                return strtoupper($data->status);
                                            }
                                        ],
                                        'create_on',
                                    ],
                            ]); ?>
                        </div>
                        <div class="col-md-12">
                            <?php Pjax::begin(); ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'purchase_no',
                                    [
                                        'attribute'=> 'prod_id',
                                        'label'=>'Product Name',
                                        'format'=> 'raw',
                                        'value'=> function ($data){
                                            $product = \app\models\Product::findOne($data['prod_id']);
                                            if (!$product){
                                                return '-';
                                            }
                                            return $product->prod_name;
                                        }
                                    ],
                                    [
                                        'attribute'=> 'supplier_id',
                                        'label'=>'Supplier Name',
                                        'format'=> 'raw',
                                        'value'=> function ($data){
                                            $supplier = \app\models\Supplier::findOne($data['supplier_id']);
                                            if (!$supplier){
                                                return '-';
                                            }
                                            return $supplier->contact_fname.' '.$supplier->contact_sname;
                                        }
                                    ],
                                    'payment_code',
                                    [
                                        'attribute'=>'original_qty',
                                        'format' => ['decimal', 0],
                                        'hAlign'=>'right',
                                        'pageSummary' => true,
                                        'footer' => true,
                                    ],
                                    [
                                        'attribute'=>'available_qty',
                                        'format' => ['decimal', 0],
                                        'hAlign'=>'right',
                                        'pageSummary' => true,
                                        'footer' => true,
                                    ],
                                    [
                                        'attribute'=>'price_per_unit',
                                        'format' => ['decimal', 2],
                                        'hAlign'=>'right',
                                        'pageSummary' => true,
                                        'footer' => true,
                                    ],
                                    [
                                        'width'=>'15%',
                                        'attribute' => 'status',
                                        'filterType' => GridView::FILTER_SELECT2,
                                        'filter' => [
                                            "pending"=>"PENDING",
                                            "approved"=>"APPROVED",
                                            "completed" => "COMPLETED",
                                            "cancelled" => "CANCELLED",
                                        ],
                                        'filterWidgetOptions' => [
                                            'hideSearch' => true,
                                            'pluginOptions' => ['allowClear' => true],
                                        ],
                                        'filterInputOptions' => ['prompt' => '-- All Status --', 'multiple' => false], // allows multiple authors to be chosen
                                        'format' => 'raw',
                                        'value' => function ($data){
                                            return strtoupper($data->status);
                                        }
                                    ],
                                    'create_on',
                                ],
                                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                                // set export properties
                                'export' => [
                                    'fontAwesome' => true
                                ],
                                // parameters from the demo form
                                'bordered' => true,
                                'striped' => true,
                                'condensed' => false,
                                'responsive' => true,
                                'hover' => true,
                                //'perfectScrollbar'=>true,
                                'showPageSummary' => true,
                                'responsiveWrap' => false,
                                'persistResize' => false,
                            ]); ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
