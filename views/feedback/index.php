<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-info">
                <h4 class="card-title">Feedback</h4>
                <p class="card-category">View all messages sent</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <?= ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'kartik\grid\SerialColumn'],

                                //'id',
                                //'user_id',
                                'email:email',
                                'status',
                                'subject',
                                'message:ntext',
                                'reply:ntext',
                                'date_sent:date',
                                'date_reply:date',

                                ['class' => 'kartik\grid\ActionColumn'],
                            ],
                        ]);?>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <?php Pjax::begin(['id' => 'feedback']) ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'email:email',
                                    'subject',
                                    'message:ntext',
                                    [
                                         'attribute'=>'reply',
                                        'format'=>'raw',
                                        'width'=>'50%',
                                        'value'=>function($data){
                                              if ($data->reply!=null){
                                                  return $data->reply;
                                              }else{
                                                  return " <form method='post' action='".\yii\helpers\Url::to(["/feedback/reply"])."'>
                                                    <div class='form-group'
                                                    <input type='hidden' name='_csrf' value=".md5($data->id.$data->id).">
                                                    <input type='hidden' name='feedback_id' value='".$data->id."'>
                                                         <div class='form-group bmd-form-group'>
                                                              <label class='bmd-label-floating'>Type message</label>
                                                              <textarea class='form-control' rows='3' name='reply' required></textarea>
                                                          </div>
                                                      </div>
                                                     <div class='form-group float-right'>
                                                     <button type='reset' class='btn btn-outline-danger btn-sm'>Cancel</button>
                                                     <button type='submit' class='btn btn-info btn-sm' name='btn_send'>Send</button>  
                                                     
                                                     </div>
                                                    
                                                    </form>";
                                              }
                                        }
                                    ],
                                    //'date_sent:date',
                                    //'date_reply:date',

                                    //['class' => 'yii\grid\ActionColumn'],
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

