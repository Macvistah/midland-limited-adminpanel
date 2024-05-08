<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Existing Suppliers</h4>
                    <p class="card-category">View all the suppliers</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-right">
                                <?= Html::a('Create Supplier', ['create'], ['class' => 'btn btn-info']) ?>
                            </p>
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    //'id',
                                    'id',
                                    'contact_fname',
                                    'contact_sname',
                                    'contact_gender',
                                    'contact_phone',
                                    'company_name',
                                    'contact_email:email',
                                    'location:ntext',
                                    'national_id',
                                    'kra_pin',
                                    'created_on',
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(['id' => 'suppliers']) ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],

                                        'id',
                                        'contact_fname',
                                        'contact_sname',
                                        'contact_gender',
                                        'contact_phone',
                                        //'company_name',
                                        //'contact_email:email',
                                        //'location:ntext',
                                        //'national_id',
                                        //'kra_pin',
                                        //'created_on',

                                        ['class' => 'yii\grid\ActionColumn'],
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
                                    'showPageSummary' => false,
                                    'responsiveWrap' => false,
                                    'persistResize' => false,
                                ]); ?>

                                <?php Pjax::end()?>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
