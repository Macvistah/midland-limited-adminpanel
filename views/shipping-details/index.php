<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ShippingDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shipping Details');
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
            'attribute' => 'order_id',
        'value' => function ($data){
          $order = \app\models\Order::findOne($data['order_id']);
          return $order->order_no;
        }
    ],
    [
        'label' => 'Order Status',
        'value' => function ($data){
            $order = \app\models\Order::findOne($data['order_id']);
            return $order->status;
        }
    ],
    'full_name',
    'phone_no',
    'location:ntext',
    [
        'attribute' => 'driver_id',
        'value' => function ($data){
            $user = \app\models\Users::findOne($data['driver_id']);
            if ($user){
                return $user->username;
            }
            return "Not Assigned";
        }
    ],
    //'driver_id',
    'delivery_date',

];
?>
<div class="shipping-details-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Shipment Report</h4>
                    <p class="card-category">View all shipping details</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridColumns,
                            ]);?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => $gridColumns,
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
