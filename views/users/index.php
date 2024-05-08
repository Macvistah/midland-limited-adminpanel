<?php

use kartik\grid\GridView;
use yii\bootstrap4\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">User Accounts</h4>
                    <p class="card-category">View all the user accounts</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(); ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        'username',
                                        'email:email',
                                        [
                                            'attribute'=>'user_type',
                                            'value'=>function($data){
                                                    if ($data->user_type!=null){
                                                        return ucfirst($data->user_type);
                                                    }
                                                    else{
                                                        return null;
                                                    }
                                            }
                                        ],
                                        [
                                           'attribute'=>'status',
                                            'format' => 'raw',
                                            'value'=>function($data){
                                                if($data->status ==  'active'){
                                                    return  ButtonDropdown::widget([
                                                        'label' => 'Active',
                                                        'buttonOptions'=>[
                                                                'class'=>'btn btn-info'
                                                        ],
                                                        'dropdown' => [
                                                            'items' => [
                                                                ['label' => 'Activate', 'url' => ['status','id' => $data->id,'action'=>'active'],
                                                                    'disabled'=>true,
                                                                    'linkOptions' => [
                                                                        'data-method' => 'post',
                                                                    ],
                                                                ],
                                                                '<div class="dropdown-divider"></div>',
                                                                ['label' => 'Deactivate', 'url' => ['status','id' => $data->id,'action'=>'blocked']],
                                                            ],
                                                        ],
                                                    ]);
                                                }
                                                else if($data->status ==  'blocked'){
                                                    return  ButtonDropdown::widget([
                                                        'label' => 'Blocked',
                                                        'buttonOptions'=>[
                                                            'class'=>'btn btn-danger'
                                                        ],
                                                        'dropdown' => [
                                                            'items' => [
                                                                ['label' => 'Activate', 'url' => ['status','id' => $data->id,'action'=>'active'],
                                                                    'linkOptions' => [
                                                                        'data-method' => 'post',
                                                                    ],
                                                                ],
                                                                '<div class="dropdown-divider"></div>',
                                                                ['label' => 'Deactivate', 'url' => ['status','id' => $data->id,'action'=>'blocked'],
                                                                    'disabled'=>true,],
                                                            ],
                                                        ],
                                                    ]);
                                                }
                                                else if($data->status ==  'pending'){
                                                    return  ButtonDropdown::widget([
                                                        'label' => 'Pending',
                                                        'buttonOptions'=>[
                                                            'class'=>'btn btn-warning'
                                                        ],
                                                        'dropdown' => [
                                                            'items' => [
                                                                ['label' => 'Activate', 'url' => ['status','id' => $data->id,'action'=>'active'],
                                                                    'linkOptions' => [
                                                                        'data-method' => 'post',
                                                                    ],
                                                                ],
                                                                '<div class="dropdown-divider"></div>',
                                                                ['label' => 'Deactivate', 'url' => ['status','id' => $data->id,'action'=>'blocked']],
                                                            ],
                                                        ],
                                                    ]);
                                                }
                                            },

                                        ],
                                        [
                                                'label'=>'Password',
                                            'format'=>'raw',
                                            'value'=>function($data){
                                                return Html::a('Reset Password?',['reset','id'=>$data->id],['class'=>'text-info']);
                                            }
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
