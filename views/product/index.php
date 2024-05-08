<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown ">
            <a href="#" data-toggle="dropdown" aria-expanded="false">
                <h6 class="text-light " data-toggle="tooltip" title="Click to add new category">Add Category</h6>
            </a>
            <ul class="dropdown-menu" x-placement="top-start" style="position: absolute; top: -110px; left: -231px; will-change: top, left;">
                <li class="header-title"> Create Category</li>
                <?php
                $modelCategory = new \app\models\ProductCategory();
                ?>
                <?= $this->render('category_form', [
                    'model' => $modelCategory,
                ]);?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <p class="pull-left">
                                <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Create Purchase', ['purchases/create'], ['class' => 'btn btn-info ']) ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <?php ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute'=>'image',
                                        'format'=>'raw',
                                        'vAlign'=>'center',
                                        'width'=>'20%',
                                        'value'=> function ($data){
                                            if ($data->image!=null){
                                                return "<img src='uploads/product_images/".$data->image."' class='product_img'>";
                                            }
                                            else{
                                                return "<p class='text-center'>No Image</p>";
                                            }
                                        }
                                    ],
                                    [
                                        'attribute'=>'prod_name',
                                        'width'=>'15%',
                                        'vAlign'=>'center',
                                    ],
                                    [
                                        'attribute'=>'category_id',
                                        'width'=>'15%',
                                        'value'=>function($data){
                                            if ($data->category_id!=null){
                                                $categoryModel = \app\models\ProductCategory::findOne(['id'=>$data->category_id]);
                                                if ($categoryModel){
                                                    return $categoryModel->name;
                                                }
                                            }
                                            else{
                                                return '-';
                                            }
                                        },
                                    ],
                                    [
                                        'attribute'=>'qty',
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                        'width'=>'10%',
                                        'hAlign'=>'right',
                                        'vAlign'=>'center',
                                    ],
                                    [
                                        'attribute'=>'price',
                                        'width'=>'15%',
                                        'hAlign'=>'right',
                                        'vAlign'=>'center',
                                        'format'=>['decimal',2]
                                    ],
                                    [
                                        'attribute'=>'discount',
                                        'label'=>'Discount(%)',
                                        'width'=>'15%',
                                        'hAlign'=>'right',
                                        'vAlign'=>'center',
                                        'format'=>['decimal',2],
                                        'value'=>function($data){
                                            return $data->discount;
                                        }
                                    ],
                                    [
                                        'attribute'=>'discount',
                                        'label'=>'Discount Price(ksh)',
                                        'width'=>'15%',
                                        'hAlign'=>'right',
                                        'vAlign'=>'center',
                                        'format'=>['decimal',2],
                                        'value'=>function($data){
                                            return $data->discount/100*$data->price;
                                        }
                                    ],
                                    [
                                        'attribute'=>'price',
                                        'label'=>'Final Price(ksh)',
                                        'width'=>'15%',
                                        'hAlign'=>'right',
                                        'vAlign'=>'center',
                                        'format'=>['decimal',2],
                                        'value'=>function($data){
                                            return $data->price-($data->discount/100*$data->price);
                                        }
                                    ],

                                    [
                                        'attribute'=>'description',
                                    ],
                                ],
                            ]);?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>

                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'responsiveWrap'=>false,
                                    'columns' => [
                                        ['class' => 'kartik\grid\SerialColumn'],
                                        [
                                            'attribute'=>'image',
                                            'format'=>'raw',
                                            'vAlign'=>'center',
                                            'width'=>'20%',
                                            'value'=> function ($data){
                                                if ($data->image!=null){
                                                    return "<img src='uploads/product_images/".$data->image."' class='product_img'>";
                                                }
                                                else{
                                                    return "<p class='text-center'>No Image</p>";
                                                }
                                            }
                                        ],
                                        [
                                            'attribute'=>'prod_name',
                                            'width'=>'15%',
                                            'vAlign'=>'center',
                                        ],
                                        [
                                            'attribute'=>'category_id',
                                            'width'=>'7%',
                                            'value'=>function($data){
                                                if ($data->category_id!=null){
                                                    $categoryModel = \app\models\ProductCategory::findOne(['id'=>$data->category_id]);
                                                    if ($categoryModel){
                                                        return $categoryModel->name;
                                                    }
                                                }
                                                else{
                                                    return '-';
                                                }
                                            },
                                        ],
                                        [
                                            'attribute'=>'qty',
                                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                                            'width'=>'7%',
                                            'hAlign'=>'right',
                                            'vAlign'=>'center',
                                        ],
                                        [
                                            'attribute'=>'price',
                                            'width'=>'10%',
                                            'hAlign'=>'right',
                                            'vAlign'=>'center',
                                            'format'=>['decimal',2]
                                        ],
                                        [
                                            'attribute'=>'discount',
                                            'label'=>'Discount(%)',
                                            'width'=>'7%',
                                            'hAlign'=>'right',
                                            'vAlign'=>'center',
                                            'format'=>['decimal',2],
                                            'value'=>function($data){
                                                return $data->discount;
                                            }
                                        ],
                                        [
                                            'attribute'=>'discount',
                                            'label'=>'Discount Price(ksh)',
                                            'width'=>'10%',
                                            'hAlign'=>'right',
                                            'vAlign'=>'center',
                                            'format'=>['decimal',2],
                                            'value'=>function($data){
                                                return $data->discount/100*$data->price;
                                            }
                                        ],
                                        [
                                            // 'attribute'=>'price',
                                            'label'=>'Final Price(ksh)',
                                            'width'=>'10%',
                                            'hAlign'=>'right',
                                            'vAlign'=>'center',
                                            'format'=>['decimal',2],
                                            'value'=>function($data){
                                                return $data->price-($data->discount/100*$data->price);
                                            }
                                        ],
                                        [
                                            'attribute'=>'description',
                                        ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'visibleButtons'=>[
                                                'delete'=>false,
                                            ]
                                        ],
                                    ],
                                ]); ?>

                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
