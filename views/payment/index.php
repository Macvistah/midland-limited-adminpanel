<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = $this->title;
$gridColumn = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'pageSummary'=>'Total Amount',
        'pageSummaryOptions' => ['colspan' => 5],

    ],
    'payment_id',
    [
        'label' => 'Payment Mode',
        'value' => function ($data){
            return "MPESA";
        }
    ],
    [
        'attribute'=> 'user_id',
        'label'=>'Paid By',
        'format'=> 'raw',
        'value'=> function ($data){
            $user = \app\models\Users::findOne($data['user_id']);
            if (!$user){
                return '-';
            }
            return $user->username;
        }
    ],

    [
        'label'=>'Date',
        'attribute'=>'order_date',
        'format'=>'date',
    ],
    [
        'attribute'=>'total_amount',
        'format' => ['decimal', 2],
        'hAlign'=>'right',
        'pageSummary' => true,
        'footer' => true,

    ],
];
?>
<div class="payment-index">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Payments</h4>
                    <p class="card-category">View all payments made</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridColumn,
                            ]);?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => $gridColumn,
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
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
