<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Help */

$this->title = 'View FAQ';
$this->params['breadcrumbs'][] = ['label' => 'Help', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$modelTitle = \app\models\HelpTitle::findOne(['id'=>$model->title_id]);
?>
<div class="help-view">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">View FAQ</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    //'id',
                                    [
                                            'attribute'=>'title_id',
                                            'value'=>$modelTitle->title,
                                    ],
                                    'user_type',
                                    'question:ntext',
                                    'answer:ntext',
                                    'created_on:date',
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <p class="pull-right">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
