<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders Report');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title"><?=$this->title?></h4>
                    <p class="card-category">View all the orders</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'order_no',
                                    [
                                        'attribute'=> 'user_id',
                                        'label'=>'Customer Name',
                                        'format'=> 'raw',
                                        'value'=> function ($data){
                                            $user = \app\models\Users::findOne($data['user_id']);
                                            if (!$user){
                                                return '-';
                                            }
                                            return $user->username;
                                        }
                                    ],
                                    'payment_id',
                                    [
                                        'attribute'=>'shipping_charge',
                                        'format' => ['decimal', 2],
                                        'hAlign'=>'right',
                                    ],
                                    [
                                        'attribute'=>'total_amount',
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
                                            "delivered" => "DELIVERED",
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
                                    'order_date',
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
                                    'order_no',
                                    [
                                        'attribute'=> 'user_id',
                                        'label'=>'Customer Name',
                                        'format'=> 'raw',
                                        'value'=> function ($data){
                                            $user = \app\models\Users::findOne($data['user_id']);
                                            if (!$user){
                                                return '-';
                                            }
                                            return $user->username;
                                        }
                                    ],
                                    'payment_id',
                                    [
                                        'attribute'=>'shipping_charge',
                                        'format' => ['decimal', 2],
                                        'hAlign'=>'right',
                                        'pageSummary' => true,
                                        'footer' => true,
                                    ],
                                    [
                                        'attribute'=>'total_amount',
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
                                                "delivered" => "DELIVERED",
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
                                    'order_date',
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
