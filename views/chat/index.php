<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ChatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Chats');
$this->params['breadcrumbs'][] = $this->title;


$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
//        'groupedRow'=> true,
        'group' => true,  // enable grouping
        'attribute'=>'sender_id',
        'width' => '150px',
        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        'value'=> function($data){
            $user = \app\models\Users::findOne($data['sender_id']);
            return $user->username;
        },
    ],
    [
        'group' => true,  // enable grouping
        'attribute'=> 'recipient_id',
        'width' => '150px',
        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
        'value'=> function($data){
            $user = \app\models\Users::findOne($data['recipient_id']);
            return $user->username;
        },
    ],
    'message:ntext',
    'status',
    //'deleted_on',
    'created_on',
    //'updated_on',

//            ['class' => 'yii\grid\ActionColumn'],
]
?>
<div class="chat-index">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Chat History</h4>
                    <p class="card-category">View all the chats</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= ExportMenu::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => $gridColumns
                            ]);?>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?php Pjax::begin(['id' => 'chats']) ?>
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
