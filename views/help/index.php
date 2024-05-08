<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\HelpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Help Centre';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-index">
    <div class="fixed-plugin">
        <div class="dropdown show-dropdown ">
            <a href="#" data-toggle="dropdown" aria-expanded="false">
                <h6 class="text-light " data-toggle="tooltip" title="Click to add new title">Add Title</h6>
            </a>
            <ul class="dropdown-menu" x-placement="top-start" style="position: absolute; top: -110px; left: -231px; will-change: top, left;">
                <li class="header-title"> Create Title</li>
                <?php
                $modelHelpTitle = new \app\models\HelpTitle();
                ?>
                    <?= $this->render('title_form', [
                    'model' => $modelHelpTitle,
                    ]);?>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Help Center</h4>
                    <p class="card-category">View and manage the FAQ's</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="pull-right">
                                <?= Html::a('Create FAQ', ['create'], ['class' => 'btn btn-info']) ?>
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(['id' => 'help']) ?>
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'filterModel' => $searchModel,
                                    'columns' => [
                                        ['class' => 'yii\grid\SerialColumn'],
                                        [
                                            'attribute'=>'title_id',
                                            'value'=>function($data){
                                                $modelHelp = \app\models\HelpTitle::findOne(['id'=>$data->title_id]);
                                                if ($modelHelp){
                                                    return $modelHelp->title;
                                                }
                                                else{
                                                    return null;
                                                }
                                            },

                                         ],
                                        [
                                             'attribute'=>'user_type',
                                            'label'=>'Visible To',
                                            'value'=>function ($data){
                                                if ($data->user_type!=null){
                                                    return ucfirst($data->user_type);
                                                }
                                                else{
                                                    return null;
                                                }

                                            }
                                        ],
                                        'question:ntext',
                                        'answer:ntext',
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
