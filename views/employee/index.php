<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Existing Employees</h4>
                    <p class="card-category">View all the employees</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-right">
                                <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-info btn-sm']) ?>
                            </p>
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    //'id',
                                    'fname',
                                    'sname',
                                    'gender',
                                    'national_id',
                                    'email:email',
                                    'phone_no',
                                    'marital_status',
                                    'role',
                                    'location',
                                    'address',
                                    'postal_code',
                                    'created_on',
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(['id' => 'employees']) ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        //'id',
                                        'fname',
                                        'sname',
                                        'gender',
                                        'national_id',
                                        'email:email',
                                        'phone_no',
                                        'marital_status',
                                        'role',
                                        //'location',
                                        //'address',
                                        //'postal_code',
                                        //'created_on',

                                        [
                                                'class' => 'yii\grid\ActionColumn',
                                            'visibleButtons'=>[
                                                'delete'=>false,
                                            ],
                                        ],
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
