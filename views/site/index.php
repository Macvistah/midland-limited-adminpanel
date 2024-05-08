<?php

use rce\material\widgets\Card;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
$customers = \app\models\Customer::find()->count();
$suppliers = \app\models\Supplier::find()->count();
$users = \app\models\Users::find()->count();
$employees = \app\models\Employee::find()->count();
$messages = \app\models\Feedback::find() -> where(['status'=>'unread'])->count();
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">people</i>',
                    'color'=>'info',
                    'title'=>$customers,
                    'subtitle'=>'Total Customers',
                    'footer'=>'<div class="stats">
                            <i class="material-icons text-warning">persons</i>
                            <a href="'.Url::to(['/customer']).'" class="text-warning">View Customers</a>
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">people</i>',
                    'color'=>'success',
                    'title'=>$employees,
                    'subtitle'=>'Total Staff',
                    'footer'=>'<div class="stats">
                            <i class="material-icons text-success">persons</i>
                             <a href="'.Url::to(['/employee']).'" class="text-success">View Staff</a>
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">people</i>',
                    'color'=>'warning',
                    'title'=>$suppliers,
                    'subtitle'=>'Total Suppliers',
                    'footer'=>'<div class="stats">
                            <i class="material-icons text-warning">persons</i>
                            <a href="'.Url::to(['/supplier']).'" class="text-warning">View Suppliers</a>
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">people</i>',
                    'color'=>'secondary',
                    'title'=>$users,
                    'subtitle'=>'User Accounts',
                    'footer'=>'<div class="stats">
                           <i class="material-icons text-danger">people</i>
                             <a href="'.Url::to(['/users']).'" class="text-danger">View Users</a>
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-12 col-md-8 col-sm-12">
                <div class="card card-chart">
                    <div class="card-header card-header-info">
                        <h4 class="card-title">User Account Creation Report</h4>
                        <p class="card-category"></p>
                    </div>
                    <div class="card-body">
                        <?php
//                        echo $this->renderAjax('../users/index');
                        $userModel = new \app\models\Users();
                        $series = [
                            [
                                'name' => 'User Accounts',
                                'data' => [
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-11 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-10 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-9 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-8 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-7 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-6 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-5 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-4 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-3 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-2 Months'))),
                                    $userModel->getUserAccounts(date('Y-m',strtotime('-1 Months'))),
                                    $userModel->getUserAccounts(date('Y-m')),

                                ],
                            ],
                        ];
                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                            'type' => 'bar', // default area
                            'height' => '400', // default 350
                            'chartOptions' => [
                                'chart' => [
                                    'toolbar' => [
                                        'show' => true,
                                        'autoSelected' => 'zoom'
                                    ],
                                ],
                                'xaxis' => [
                                    // 'type' => 'datetime',
                                    'title'=>[
                                        'text'=>'Months',
                                    ],
                                    'lable'=>'Months',

                                    'categories' => [date("F",strtotime("-7 Months")),date("F",strtotime("-6 Months")),date("F",strtotime("-5 Months")),date("F",strtotime("-4 Months")),date("F",strtotime("-3 Months")),date("F",strtotime("-2 Months")),date("F",strtotime("-1 Months")),date("F")],
                                ],
                                'yaxis'=>[
                                    'title'=>[
                                        'text'=>'User Accounts',
                                    ],
                                ],
                                'plotOptions' => [
                                    'bar' => [
                                        'horizontal' => false,
                                        'endingShape' => 'rounded'
                                    ],
                                ],
                                'dataLabels' => [
                                    'enabled' => true,
                                ],
                                'stroke' => [
                                    'show' => true,
                                    'colors' => ['transparent']
                                ],
                                'legend' => [
                                    'verticalAlign' => 'bottom',
                                    'horizontalAlign' => 'left',
                                ],
                            ],
                            'series' => $series
                        ]);
                        ?>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>
